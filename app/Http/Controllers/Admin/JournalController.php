<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class JournalController extends Controller
{
    /**
     * Daftar semua jurnal.
     */
    public function index(Request $request)
    {
        $query = Journal::with('uploader')
            ->search($request->get('q'))
            ->byCategory($request->get('category'))
            ->latest();

        // Filter status
        if ($request->filled('status')) {
            $query->where('is_published', $request->get('status') === 'published');
        }

        $journals   = $query->paginate(10)->withQueryString();
        $categories = Journal::distinct()->pluck('category')->filter()->sort()->values();
        $stats = [
            'total'      => Journal::count(),
            'published'  => Journal::where('is_published', true)->count(),
            'draft'      => Journal::where('is_published', false)->count(),
            'downloads'  => Journal::sum('download_count'),
        ];

        return view('admin.journals.index', compact('journals', 'categories', 'stats'));
    }

    /**
     * Form tambah jurnal.
     */
    public function create()
    {
        $categories = Category::where('is_active', 1)
            ->where('type', 'like', '%event%')
            ->orderBy('sort_order')
            ->pluck('name', 'id');
        return view('admin.journals.create', compact('categories'));
    }

    /**
     * Simpan jurnal baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'author'       => 'required|string|max:255',
            'file'         => 'required|file|mimes:pdf,doc,docx|max:20480',
            'abstract'     => 'nullable|string|max:2000',
            'category'     => 'nullable|string|max:100',
            'volume'       => 'nullable|string|max:50',
            'year'         => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'is_published' => 'nullable|boolean',
            'access'       => 'required|in:free,premium',
        ], [
            'file.required'  => 'File jurnal wajib diupload.',
            'file.mimes'     => 'File harus berformat PDF, DOC, atau DOCX.',
            'file.max'       => 'Ukuran file maksimal 20 MB.',
        ]);

        $file     = $request->file('file');
        $origName = $file->getClientOriginalName();
        $ext      = strtolower($file->getClientOriginalExtension());
        $safeName = Str::slug(pathinfo($origName, PATHINFO_FILENAME)) . '_' . time() . '.' . $ext;
        $path     = $file->storeAs('journals', $safeName, 'public');

        // Human readable file size
        $bytes    = $file->getSize();
        $fileSize = $bytes >= 1048576
            ? round($bytes / 1048576, 1) . ' MB'
            : round($bytes / 1024, 1) . ' KB';

        Journal::create([
            'title'        => $validated['title'],
            'author'       => $validated['author'],
            'file_path'    => $path,
            'file_name'    => $origName,
            'file_size'    => $fileSize,
            'file_type'    => $ext,
            'access'       => $validated['access'], 
            'abstract'     => $validated['abstract'] ?? null,
            'category'     => $validated['category'] ?? null,
            'volume'       => $validated['volume'] ?? null,
            'year'         => $validated['year'] ?? null,
            'is_published' => $request->boolean('is_published', true),
            'uploaded_by'  => auth()->id(),
        ]);

        return redirect()->route('admin.journals.index')
            ->with('success', 'Jurnal "' . $validated['title'] . '" berhasil ditambahkan.');
    }

    /**
     * Detail jurnal.
     */
    public function show(Journal $journal)
    {
        return view('admin.journals.show', compact('journal'));
    }

    /**
     * Form edit jurnal.
     */
    public function edit(Journal $journal)
    {
        $categories = Category::where('is_active', 1)
            ->where('type', 'like', '%event%')
            ->orderBy('sort_order')
            ->pluck('name', 'id');
        return view('admin.journals.edit', compact('journal', 'categories'));
    }

    /**
     * Update jurnal.
     */
    public function update(Request $request, Journal $journal)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'author'       => 'required|string|max:255',
            'file'         => 'nullable|file|mimes:pdf,doc,docx|max:20480',
            'abstract'     => 'nullable|string|max:2000',
            'category'     => 'nullable|string|max:100',
            'volume'       => 'nullable|string|max:50',
            'year'         => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'is_published' => 'nullable|boolean',
            'access'       => 'required|in:free,premium',
        ], [
            'file.mimes' => 'File harus berformat PDF, DOC, atau DOCX.',
            'file.max'   => 'Ukuran file maksimal 20 MB.',
        ]);

        $data = [
            'title'        => $validated['title'],
            'author'       => $validated['author'],
            'abstract'     => $validated['abstract'] ?? null,
            'category'     => $validated['category'] ?? null,
            'volume'       => $validated['volume'] ?? null,
            'year'         => $validated['year'] ?? null,
            'access'       => $validated['access'], 
            'is_published' => $request->boolean('is_published', true),
        ];

        // Ganti file jika ada upload baru
        if ($request->hasFile('file')) {
            // Hapus file lama
            if ($journal->file_path && Storage::disk('public')->exists($journal->file_path)) {
                Storage::disk('public')->delete($journal->file_path);
            }

            $file     = $request->file('file');
            $origName = $file->getClientOriginalName();
            $ext      = strtolower($file->getClientOriginalExtension());
            $safeName = Str::slug(pathinfo($origName, PATHINFO_FILENAME)) . '_' . time() . '.' . $ext;
            $path     = $file->storeAs('journals', $safeName, 'public');
            $bytes    = $file->getSize();

            $data['file_path'] = $path;
            $data['file_name'] = $origName;
            $data['file_type'] = $ext;
            $data['file_size'] = $bytes >= 1048576
                ? round($bytes / 1048576, 1) . ' MB'
                : round($bytes / 1024, 1) . ' KB';
        }

        $journal->update($data);

        return redirect()->route('admin.journals.index')
            ->with('success', 'Jurnal berhasil diperbarui.');
    }

    /**
     * Hapus jurnal (file ikut terhapus via model booted).
     */
    public function destroy(Journal $journal)
    {
        $title = $journal->title;
        $journal->delete(); // file dihapus otomatis via model observer

        return redirect()->route('admin.journals.index')
            ->with('success', 'Jurnal "' . $title . '" berhasil dihapus.');
    }

    /**
     * Download file jurnal dan tambah counter.
     */
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

    /**
     * Toggle status publish.
     */
    public function togglePublish(Journal $journal)
    {
        $journal->update(['is_published' => !$journal->is_published]);

        $status = $journal->is_published ? 'dipublikasikan' : 'dijadikan draft';

        return back()->with('success', "Jurnal berhasil {$status}.");
    }
}
