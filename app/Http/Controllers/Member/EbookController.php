<?php
namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Ebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EbookController extends Controller
{
    public function index(Request $request)
    {
        $query = Ebook::where('is_published', true)->latest();

        if ($request->filled('q'))
            $query->where('title','like','%'.$request->q.'%')
                  ->orWhere('author','like','%'.$request->q.'%');

        if ($request->filled('access'))
            $query->where('access', $request->access);

        if ($request->filled('category'))
            $query->where('category', $request->category);

        $ebooks     = $query->paginate(12)->withQueryString();
        $categories = Ebook::where('is_published',true)->distinct()->pluck('category')->filter();

        return view('member.ebooks.index', compact('ebooks','categories'));
    }

    public function download(Ebook $ebook)
    {
        abort_if(!$ebook->is_published, 404);

        $user = auth()->user();

        if ($ebook->isPremium() && !$user->isPremium()) {
            return back()->with('error', 'Ebook ini hanya untuk member premium.');
        }

        $ebook->increment('download_count');
        return Storage::disk('public')->download($ebook->file_path, $ebook->title.'.pdf');
    }
}