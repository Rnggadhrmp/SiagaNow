<?php

namespace App\Http\Controllers;

use App\Models\WeatherWarning;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WeatherWarningController extends Controller
{
    private const FEED_URL = 'https://www.bmkg.go.id/alerts/nowcast/id';

    public function check(Request $request)
    {
        $validated = $request->validate([
            'lat' => ['required', 'numeric', 'between:-90,90'],
            'lng' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $lat = (float) $validated['lat'];
        $lng = (float) $validated['lng'];

        try {
            $result = Cache::remember(
                'bmkg_nowcast_point_' . md5($lat . ',' . $lng),
                now()->addMinutes(2),
                fn () => $this->findWarningsAtPoint($lat, $lng)
            );

            return response()->json([
                'status' => $result['status'],
                'message' => $result['message'],
                'location' => ['lat' => $lat, 'lng' => $lng],
                'warnings' => $result['warnings'],
                'source' => 'BMKG',
                'source_url' => self::FEED_URL,
                'checked_at' => now()->toIso8601String(),
            ], $result['status'] === 'unknown' ? 503 : 200);
        } catch (\Throwable $e) {
            Log::warning('Gagal mengambil peringatan BMKG', [
                'message' => $e->getMessage(), 'lat' => $lat, 'lng' => $lng,
            ]);

            return response()->json([
                'status' => 'unknown',
                'message' => 'Feed BMKG atau detail wilayah belum dapat diverifikasi. Coba lagi nanti.',
                'warnings' => [],
                'source' => 'BMKG',
                'source_url' => self::FEED_URL,
            ], 503);
        }
    }

    private function findWarningsAtPoint(float $lat, float $lng): array
    {
        $response = Http::timeout(12)
            ->withHeaders(['User-Agent' => 'SiagaNow/1.0'])
            ->get(self::FEED_URL);
        $response->throw();

        $feed = $this->parseXml($response->body());
        $items = $feed->xpath('//*[local-name()="item"]') ?: [];
        $matches = [];
        $detailFailures = 0;
        $checkedDetails = 0;
        $geometryFailures = 0;
        $maxItems = 30;
        $fetchedAt = now();

        foreach (array_slice($items, 0, $maxItems) as $item) {
            $title = $this->xmlValue($item, 'title') ?: 'Peringatan dini cuaca';
            $link = $this->xmlValue($item, 'link');
            $description = $this->xmlValue($item, 'description');
            $pubDate = $this->parseDate($this->xmlValue($item, 'pubDate'));

            if (!$link || !filter_var($link, FILTER_VALIDATE_URL)) {
                $detailFailures++;
                continue;
            }

            try {
                $detailResponse = Http::timeout(8)
                    ->withHeaders(['User-Agent' => 'SiagaNow/1.0'])
                    ->get($link);
                $detailResponse->throw();
                $cap = $this->parseXml($detailResponse->body());
                $checkedDetails++;

                $identifier = $this->firstXmlValue($cap, ['identifier']) ?: hash('sha256', $link);
                $area = $this->firstXmlValue($cap, ['areaDesc']);
                $category = $this->firstXmlValue($cap, ['category']);
                $effective = $this->parseDate($this->firstXmlValue($cap, ['effective']));
                $expires = $this->parseDate($this->firstXmlValue($cap, ['expires']));
                $polygons = [];
                foreach (($cap->xpath('//*[local-name()="polygon"]') ?: []) as $polygonNode) {
                    $polygon = trim((string) $polygonNode);
                    if ($polygon !== '') {
                        $polygons[] = $polygon;
                    }
                }

                WeatherWarning::updateOrCreate(
                    ['external_id' => $identifier],
                    [
                        'title' => $title,
                        'description' => $description,
                        'area_description' => $area ?: null,
                        'detail_url' => $link,
                        'category' => $category ?: null,
                        'published_at' => $pubDate,
                        'effective_at' => $effective,
                        'expires_at' => $expires,
                        'polygons' => $polygons,
                        'source' => 'BMKG',
                        'last_fetched_at' => $fetchedAt,
                    ]
                );

                $isCurrent = (!$effective || $effective->lessThanOrEqualTo($fetchedAt))
                    && (!$expires || $expires->greaterThanOrEqualTo($fetchedAt));

                if ($isCurrent && count($polygons) > 0) {
                    foreach ($polygons as $polygon) {
                        $inside = $this->pointInPolygon($polygon, $lat, $lng);

                        if ($inside === null) {
                            $geometryFailures++;
                            continue;
                        }

                        if ($inside) {
                            $matches[] = [
                                'id' => $identifier,
                                'title' => $title,
                                'description' => $description,
                                'area' => $area ?: null,
                                'published_at' => $pubDate?->toIso8601String(),
                                'effective_at' => $effective?->toIso8601String(),
                                'expires_at' => $expires?->toIso8601String(),
                                'detail_url' => $link,
                            ];
                            break;
                        }
                    }
                } elseif (count($polygons) === 0) {
                    $detailFailures++;
                }
            } catch (\Throwable $e) {
                $detailFailures++;
                Log::notice('Detail CAP BMKG tidak dapat diperiksa', [
                    'url' => $link, 'message' => $e->getMessage(),
                ]);
            }
        }

        if (count($matches) > 0) {
            return ['status' => 'warning_found', 'message' => 'Poligon peringatan BMKG yang masih berlaku mencakup titik lokasi yang dipilih.', 'warnings' => $matches];
        }

        if (count($items) > $maxItems || $detailFailures > 0 || $geometryFailures > 0 || ($items && $checkedDetails === 0)) {
            return ['status' => 'unknown', 'message' => 'Sebagian detail peringatan belum dapat diperiksa; status lokasi belum bisa dipastikan.', 'warnings' => []];
        }

        return ['status' => 'no_warning_found', 'message' => 'Tidak ditemukan poligon peringatan BMKG yang masih berlaku dan mencakup titik ini. Ini bukan jaminan lokasi aman.', 'warnings' => []];
    }

    private function parseXml(string $xmlText): \SimpleXMLElement
    {
        $previous = libxml_use_internal_errors(true);
        try {
            $xml = simplexml_load_string($xmlText, \SimpleXMLElement::class, LIBXML_NONET | LIBXML_NOCDATA);
            if ($xml === false) {
                throw new \RuntimeException('Respons sumber bukan XML yang valid.');
            }
            return $xml;
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previous);
        }
    }

    private function xmlValue(\SimpleXMLElement $node, string $name): string
    {
        $found = $node->xpath('./*[local-name()="' . $name . '"]');
        return isset($found[0]) ? trim((string) $found[0]) : '';
    }

    private function firstXmlValue(\SimpleXMLElement $node, array $names): string
    {
        foreach ($names as $name) {
            $found = $node->xpath('//*[local-name()="' . $name . '"]');
            if (isset($found[0]) && trim((string) $found[0]) !== '') {
                return trim((string) $found[0]);
            }
        }
        return '';
    }

    private function parseDate(string $value): ?Carbon
    {
        if (trim($value) === '') {
            return null;
        }
        try {
            return Carbon::parse($value);
        } catch (\Throwable) {
            return null;
        }
    }

    /** CAP polygons use "latitude,longitude latitude,longitude ...". */
    private function pointInPolygon(string $polygon, float $lat, float $lng): ?bool
    {
        $points = [];
        $pairs = preg_split('/\s+/', trim($polygon), -1, PREG_SPLIT_NO_EMPTY);
        if (!$pairs) {
            return null;
        }

        foreach ($pairs as $pair) {
            $coords = explode(',', trim($pair));
            if (count($coords) !== 2 || !is_numeric($coords[0]) || !is_numeric($coords[1])) {
                return null;
            }

            $pointLat = (float) $coords[0];
            $pointLng = (float) $coords[1];
            if ($pointLat < -90 || $pointLat > 90 || $pointLng < -180 || $pointLng > 180) {
                return null;
            }

            $points[] = [$pointLat, $pointLng];
        }

        $count = count($points);
        if ($count < 3) {
            return null;
        }

        $inside = false;
        for ($i = 0, $j = $count - 1; $i < $count; $j = $i++) {
            [$yi, $xi] = $points[$i];
            [$yj, $xj] = $points[$j];
            $crosses = (($yi > $lat) !== ($yj > $lat))
                && ($lng < (($xj - $xi) * ($lat - $yi) / (($yj - $yi) ?: 1.0)) + $xi);
            if ($crosses) {
                $inside = !$inside;
            }
        }
        return $inside;
    }
}
