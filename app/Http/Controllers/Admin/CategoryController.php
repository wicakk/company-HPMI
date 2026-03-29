<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->q.'%')
                  ->orWhere('slug', 'like', '%'.$request->q.'%');
            });
        }

        // Filter type (JSON TEXT)
        if ($request->filled('type')) {
            $query->where('type', 'like', '%"'.$request->type.'"%');
        }

        // ❌ HAPUS filter status karena kolom tidak ada

        $categories = $query->orderBy('name')
                            ->paginate(10)
                            ->withQueryString();

        $stats = [
            'total'   => Category::count(),
            'artikel' => Category::where('type', 'like', '%"artikel"%')->count(),
            'jurnal'  => Category::where('type', 'like', '%"jurnal"%')->count(),
            'materi'  => Category::where('type', 'like', '%"materi"%')->count(),
        ];

        return view('admin.categories.index', compact('categories', 'stats'));
    }

    public function create()
    {
        return view('admin.categories.form', ['category' => null]);
    }

    public function toggleActive(Category $category)
    {
        $category->update([
            'is_active' => !$category->is_active,
        ]);

        $status = $category->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()
                        ->with('success', 'Kategori "'.$category->name.'" berhasil '.$status.'.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100|unique:categories,name',
            'color'      => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'type'       => 'required|array|min:1',
            'type.*'     => 'in:artikel,jurnal,materi,ebook,event,lainnya',
            'sort_order' => 'nullable|integer|min:0',
            'is_active'  => 'nullable|boolean',
        ]);

        $data['slug']      = Str::slug($data['name']);
        $data['type']      = json_encode($request->input('type', []));
        $data['is_active'] = $request->boolean('is_active'); // ← FIX

        Category::create($data);

        return redirect()->route('admin.categories.index')
                        ->with('success', 'Kategori "'.$data['name'].'" berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.form', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:100',
                            Rule::unique('categories', 'name')->ignore($category->id)],
            'color'      => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'type'       => 'required|array|min:1',
            'type.*'     => 'in:artikel,jurnal,materi,ebook,event,lainnya',
            'sort_order' => 'nullable|integer|min:0',
            'is_active'  => 'nullable|boolean',
        ]);

        $data['slug']      = Str::slug($data['name']); // ← update slug juga
        $data['type']      = json_encode($request->input('type', []));
        $data['is_active'] = $request->boolean('is_active'); // ← FIX

        $category->update($data);

        return redirect()->route('admin.categories.index')
                        ->with('success', 'Kategori "'.$category->name.'" berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $name = $category->name;
        $category->delete();

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Kategori "'.$name.'" berhasil dihapus.');
    }

    // ❌ HAPUS fungsi toggleActive karena tidak ada kolomnya
}