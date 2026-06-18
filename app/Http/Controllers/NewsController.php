<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            $news = News::latest()->get();
            return view('admin.news.index', compact('news'));
        }

        $news = News::published()->latest('published_at')->paginate(9);
        return view('news.index', compact('news'));
    }

    public function show(string $slug)
    {
        $article = News::where('slug', $slug)->where('status', 'published')->firstOrFail();
        $related = News::published()->where('id', '!=', $article->id)->latest()->take(3)->get();
        return view('news.show', compact('article', 'related'));
    }

    public function siswaIndex()
    {
        $news = News::published()->latest('published_at')->paginate(9);
        return view('news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'body'        => 'required|string',
            'category'    => 'nullable|string|max:100',
            'cover_image' => 'nullable|image|max:3072',
            'status'      => 'required|in:draft,published',
        ]);

        $data = $request->except('cover_image');
        $data['author_id']    = auth()->id();
        $data['published_at'] = $request->status === 'published' ? now() : null;

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('news', 'public');
        }

        News::create($data);
        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil disimpan!');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'body'        => 'required|string',
            'cover_image' => 'nullable|image|max:3072',
            'status'      => 'required|in:draft,published',
        ]);

        $data = $request->except('cover_image');

        if ($request->status === 'published' && !$news->published_at) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('cover_image')) {
            if ($news->cover_image) Storage::disk('public')->delete($news->cover_image);
            $data['cover_image'] = $request->file('cover_image')->store('news', 'public');
        }

        $news->update($data);
        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function publish(News $news)
    {
        $news->update(['status' => 'published', 'published_at' => now()]);
        return back()->with('success', 'Berita berhasil dipublish!');
    }

    public function destroy(News $news)
    {
        if ($news->cover_image) Storage::disk('public')->delete($news->cover_image);
        $news->delete();
        return back()->with('success', 'Berita berhasil dihapus.');
    }
}