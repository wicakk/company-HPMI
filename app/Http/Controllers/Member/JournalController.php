<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        $query = Journal::where('is_published', true)->latest();

        if ($request->filled('q'))
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%'.$request->q.'%')
                  ->orWhere('author', 'like', '%'.$request->q.'%')
                  ->orWhere('category', 'like', '%'.$request->q.'%');
            });

        if ($request->filled('category'))
            $query->where('category', $request->category);

        $journals   = $query->paginate(12)->withQueryString();
        $categories = Journal::where('is_published', true)->distinct()->pluck('category')->filter();

        return view('member.journals.index', compact('journals', 'categories'));
    }

    public function download(Journal $journal)
    {
        if (!Storage::disk('public')->exists($journal->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        $journal->incrementDownload();

        return Storage::disk('public')->download(
            $journal->file_path,
            $journal->file_name
        );
    }

}
