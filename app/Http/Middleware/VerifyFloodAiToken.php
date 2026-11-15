<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyFloodAiToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $expected = config('services.flood_ai.ingest_token');

        if (! is_string($expected) || trim($expected) === '') {
            return response()->json([
                'status' => 'not_configured',
                'message' => 'Penerimaan data AI belum dikonfigurasi pada server.',
            ], 503);
        }

        $provided = $request->bearerToken();

        if (! is_string($provided) || ! hash_equals($expected, $provided)) {
            return response()->json([
                'status' => 'unauthorized',
                'message' => 'Kredensial layanan AI tidak valid.',
            ], 401);
        }

        return $next($request);
    }
}
