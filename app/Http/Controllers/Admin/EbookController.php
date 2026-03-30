<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ebook;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EbookController extends Controller
{
    public function index(Request $request)
    {
        $query = Ebook::latest();

        if ($request->filled('q'))
            $query->where('title','like','%'.$request->q.'%')
                  ->orWhere('author','like','%'.$request->q.'%');

        if ($request->filled('access'))
            $query->where('access', $request->access);

        if ($request->filled('status'))
            $query->where('is_published', $request->status === 'published');

        $ebooks = $query->paginate(10)->withQueryString();

        $stats = [
            'total'     => Ebook::count(),
            'free'      => Ebook::where('access','free')->count(),
            'premium'   => Ebook::where('access','premium')->count(),
            'downloads' => Ebook::sum('download_count'),
        ];

        $categories = Ebook::distinct()->pluck('category')->filter();


        return view('admin.ebooks.index', compact('ebooks','stats','categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', 1)
            ->where('type', 'like', '%event%')
            ->orderBy('sort_order')
            ->pluck('name', 'id');
        // $categories = Ebook::distinct()->pluck('category')->filter();
        return view('admin.ebooks.form', ['ebook' => null, 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'description' => 'nullable|string',
            'category'    => 'nullable|string|max:100',
            'year'        => 'nullable|integer|min:1900|max:'.date('Y'),
            'pages'       => 'nullable|integer|min:1',
            'access'      => 'required|in:free,premium',
            'is_published'=> 'boolean',
            'cover'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'file'        => 'required|file|mimes:pdf|max:51200',
        ]);

        // Upload cover
        if ($request->hasFile('cover')) {
            $data['cover_path'] = $request->file('cover')->store('ebooks/covers','public');
        }

        // Upload file PDF
        $file = $request->file('file');
        $data['file_path'] = $file->store('ebooks/files','public');
        $data['file_size'] = $this->formatSize($file->getSize());
        $data['is_published'] = $request->boolean('is_published', true);
        $data['slug'] = Str::slug($data['title']).'-'.uniqid();

        Ebook::create($data);

        return redirect()->route('admin.ebooks.index')
                         ->with('success', 'Ebook "'.$data['title'].'" berhasil ditambahkan.');
    }

    public function edit(Ebook $ebook)
    {
        $categories = Category::where('is_active', 1)
            ->where('type', 'like', '%event%')
            ->orderBy('sort_order')
            ->pluck('name', 'id');
        
        return view('admin.ebooks.form', compact('ebook','categories'));
    }

    public function update(Request $request, Ebook $ebook)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'description' => 'nullable|string',
            'category'    => 'nullable|string|max:100',
            'year'        => 'nullable|integer|min:1900|max:'.date('Y'),
            'pages'       => 'nullable|integer|min:1',
            'access'      => 'required|in:free,premium',
            'is_published'=> 'boolean',
            'cover'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'file'        => 'nullable|file|mimes:pdf|max:51200',
        ]);

        if ($request->hasFile('cover')) {
            if ($ebook->cover_path) Storage::disk('public')->delete($ebook->cover_path);
            $data['cover_path'] = $request->file('cover')->store('ebooks/covers','public');
        }

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($ebook->file_path);
            $file = $request->file('file');
            $data['file_path'] = $file->store('ebooks/files','public');
            $data['file_size'] = $this->formatSize($file->getSize());
        }

        $data['is_published'] = $request->boolean('is_published', true);
        $ebook->update($data);

        return redirect()->route('admin.ebooks.index')
                         ->with('success', 'Ebook berhasil diperbarui.');
    }

    public function destroy(Ebook $ebook)
    {
        if ($ebook->cover_path) Storage::disk('public')->delete($ebook->cover_path);
        Storage::disk('public')->delete($ebook->file_path);
        $ebook->delete();

        return back()->with('success', 'Ebook berhasil dihapus.');
    }

    public function togglePublish(Ebook $ebook)
    {
        $ebook->update(['is_published' => !$ebook->is_published]);
        return back()->with('success', 'Status ebook diperbarui.');
    }

    public function download(Ebook $ebook)
    {
        $ebook->increment('download_count');
        return Storage::disk('public')->download($ebook->file_path, $ebook->title.'.pdf');
    }

    private function formatSize(int $bytes): string
    {
        return $bytes >= 1048576
            ? round($bytes / 1048576, 1).' MB'
            : round($bytes / 1024, 1).' KB';
    }
}