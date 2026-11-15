<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use App\Services\AdminAuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $articles = NewsArticle::query()
            ->when($request->filled('status'), fn ($q) => $q->where('publication_status', $request->string('status')))
            ->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%'.$request->string('q').'%'))
            ->latest()->paginate(15)->withQueryString();

        return view('admin.news.index', compact('articles'));
    }

    public function create(): View
    {
        return view('admin.news.form', ['article' => new NewsArticle]);
    }

    public function store(Request $request, AdminAuditLogger $audit): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['author_user_id'] = $request->user()->id;
        $data['is_simulation'] = $request->boolean('is_simulation');
        $data['image_path'] = $request->file('image')?->store('news', 'public');
        unset($data['image']);
        $this->assertPublishSource($data);
        $data['published_at'] = $data['publication_status'] === 'published' ? now() : null;
        $article = NewsArticle::create($data);
        $audit->record($request, 'news.created', 'Artikel dibuat.', $article, ['publication_status' => $article->publication_status]);

        return redirect()->route('admin.news.edit', $article)->with('success', 'Artikel berhasil disimpan.');
    }

    public function edit(NewsArticle $article): View
    {
        return view('admin.news.form', compact('article'));
    }

    public function update(Request $request, NewsArticle $article, AdminAuditLogger $audit): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_simulation'] = $request->boolean('is_simulation');
        $this->assertPublishSource($data);
        if ($data['title'] !== $article->title) $data['slug'] = $this->uniqueSlug($data['title'], $article->id);
        if ($request->hasFile('image')) {
            if ($article->image_path) Storage::disk('public')->delete($article->image_path);
            $data['image_path'] = $request->file('image')->store('news', 'public');
        } else {
            unset($data['image']);
        }
        $data['published_at'] = $data['publication_status'] === 'published'
            ? ($article->published_at ?? now())
            : null;
        unset($data['image']);
        $article->update($data);
        $audit->record($request, 'news.updated', 'Artikel diperbarui.', $article, ['changed_fields' => array_keys($data)]);

        return back()->with('success', 'Artikel berhasil diperbarui.');
    }

    public function updatePublication(Request $request, NewsArticle $article, AdminAuditLogger $audit): RedirectResponse
    {
        $data = $request->validate(['publication_status' => ['required', Rule::in(['draft', 'published', 'archived'])]]);
        if ($data['publication_status'] === 'published') {
            $this->assertPublishSource($article->toArray());
        }

        $previous = $article->publication_status;
        $article->update([
            'publication_status' => $data['publication_status'],
            'published_at' => $data['publication_status'] === 'published' ? ($article->published_at ?? now()) : null,
        ]);
        $audit->record($request, 'news.publication_changed', 'Status publikasi artikel diubah.', $article, ['from' => $previous, 'to' => $article->publication_status]);

        return back()->with('success', 'Status publikasi diperbarui.');
    }

    public function destroy(NewsArticle $article, Request $request, AdminAuditLogger $audit): RedirectResponse
    {
        $title = $article->title;
        $imagePath = $article->image_path;
        $audit->record($request, 'news.deleted', 'Artikel dihapus.', $article, ['title' => $title]);
        $article->delete();
        if ($imagePath) Storage::disk('public')->delete($imagePath);

        return redirect()->route('admin.news.index')->with('success', 'Artikel berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'category' => ['required', 'string', 'max:60'],
            'summary' => ['required', 'string', 'max:2000'],
            'body' => ['required', 'string', 'max:50000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'image_alt' => ['nullable', 'string', 'max:180'],
            'source_name' => ['nullable', 'string', 'max:120'],
            'source_url' => ['nullable', 'url:http,https', 'max:2000'],
            'publication_status' => ['required', Rule::in(['draft', 'published', 'archived'])],
            'is_simulation' => ['nullable', 'boolean'],
        ]);
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'artikel';
        $slug = $base;
        $suffix = 2;
        while (NewsArticle::query()->where('slug', $slug)->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))->exists()) {
            $slug = $base.'-'.$suffix++;
        }
        return $slug;
    }

    private function assertPublishSource(array $data): void
    {
        if (($data['publication_status'] ?? null) === 'published'
            && empty($data['is_simulation'])
            && (empty($data['source_name']) || empty($data['source_url']))) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'source_url' => 'Cantumkan sumber yang dapat diperiksa sebelum menerbitkan berita aktual, atau tandai dengan jelas sebagai simulasi.',
            ]);
        }
    }
}
