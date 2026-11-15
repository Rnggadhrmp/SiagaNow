<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;
use Illuminate\View\View;

class NewsPublicController extends Controller
{
    public function index(): View
    {
        return view('berita-kebencanaan', [
            'articles' => NewsArticle::published()->latest('published_at')->paginate(10),
        ]);
    }

    public function show(NewsArticle $article): View
    {
        abort_unless($article->publication_status === 'published' && $article->published_at?->isPast(), 404);

        return view('news.show', compact('article'));
    }
}
