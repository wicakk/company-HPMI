<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleAdminController extends Controller
{
    public function index()
    {
        $articles = Article::with(['user', 'category'])->latest()->paginate(15);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::where('is_active', 1)
            ->where('type', 'like', '%event%')
            ->orderBy('sort_order')
            ->pluck('name', 'id');
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'excerpt'     => 'nullable|string|max:500',
            'content'     => 'required|string',
            'status'      => 'required|in:draft,published,archived',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Upload thumbnail
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')
                ->store('articles/thumbnails', 'public');
        }

        $data['user_id']      = auth()->id();
        $data['slug']         = Str::slug($data['title']) . '-' . time();
        $data['published_at'] = $data['status'] === 'published' ? now() : null;

        Article::create($data);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil disimpan.');
    }

    public function show(Article $artikel)
    {
        $artikel->load(['user', 'category']);
        return view('admin.articles.show', compact('artikel'));
    }

    public function edit(Article $artikel)
    {
        $categories = Category::where('is_active', 1)
            ->where('type', 'like', '%event%')
            ->orderBy('sort_order')
            ->pluck('name', 'id');
        return view('admin.articles.edit', compact('artikel', 'categories'));
    }

    public function update(Request $request, Article $artikel)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'      => 'nullable|exists:categories,id',
            'excerpt'          => 'nullable|string|max:500',
            'content'          => 'required|string',
            'status'           => 'required|in:draft,published,archived',
            'thumbnail'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'remove_thumbnail' => 'nullable|in:0,1',
        ]);

        // Hapus thumbnail jika diminta
        if ($request->input('remove_thumbnail') === '1' && $artikel->thumbnail) {
            Storage::disk('public')->delete($artikel->thumbnail);
            $data['thumbnail'] = null;
        }

        // Upload thumbnail baru (mengganti yang lama)
        if ($request->hasFile('thumbnail')) {
            // Hapus yang lama dulu
            if ($artikel->thumbnail) {
                Storage::disk('public')->delete($artikel->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')
                ->store('articles/thumbnails', 'public');
        }

        // Set published_at jika baru pertama kali diterbitkan
        if ($data['status'] === 'published' && ! $artikel->published_at) {
            $data['published_at'] = now();
        }

        // Hapus key yang tidak perlu di-update
        unset($data['remove_thumbnail']);

        $artikel->update($data);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $artikel)
    {
        // Hapus file thumbnail dari storage
        if ($artikel->thumbnail) {
            Storage::disk('public')->delete($artikel->thumbnail);
        }

        $artikel->delete();

        return back()->with('success', 'Artikel berhasil dihapus.');
    }
}