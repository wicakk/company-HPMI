<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Article, Category};
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleAdminController extends Controller
{
    public function index()
    {
        $articles = Article::with(['user','category'])->latest()->paginate(15);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::where('type','article')->get();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'excerpt'     => 'nullable|string',
            'content'     => 'required|string',
            'status'      => 'required|in:draft,published,archived',
        ]);
        $data['user_id']      = auth()->id();
        $data['slug']         = Str::slug($data['title']) . '-' . time();
        $data['published_at'] = $data['status'] === 'published' ? now() : null;
        Article::create($data);
        return redirect()->route('admin.articles.index')->with('success','Artikel berhasil disimpan.');
    }

    public function edit(Article $artikel)
    {
        $categories = Category::where('type','article')->get();
        return view('admin.articles.edit', compact('artikel','categories'));
    }

    public function update(Request $request, Article $artikel)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'excerpt'     => 'nullable|string',
            'content'     => 'required|string',
            'status'      => 'required|in:draft,published,archived',
        ]);
        if ($data['status'] === 'published' && !$artikel->published_at) {
            $data['published_at'] = now();
        }
        $artikel->update($data);
        return redirect()->route('admin.articles.index')->with('success','Artikel berhasil diperbarui.');
    }

    public function destroy(Article $artikel)
    {
        $artikel->delete();
        return back()->with('success','Artikel berhasil dihapus.');
    }

    public function show(Article $artikel) { return view('admin.articles.show', compact('artikel')); }
}
