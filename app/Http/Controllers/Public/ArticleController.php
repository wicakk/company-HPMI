<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\{Article, Category};
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with(['user','category'])->published();
        if ($request->filled('search')) {
            $query->where('title','like','%'.$request->search.'%');
        }
        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }
        $articles   = $query->latest('published_at')->paginate(9);
        $categories = Category::where('type','article')->get();
        return view('public.articles.index', compact('articles','categories'));
    }

    public function show(string $slug)
    {
        $article  = Article::with(['user','category'])->published()->where('slug',$slug)->firstOrFail();
        $article->increment('views');
        $related  = Article::with('category')->published()
            ->where('id','!=',$article->id)
            ->where('category_id',$article->category_id)
            ->latest('published_at')->take(3)->get();
        return view('public.articles.show', compact('article','related'));
    }
}
