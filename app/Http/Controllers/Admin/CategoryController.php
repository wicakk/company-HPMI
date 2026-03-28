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
            $query->where('name', 'like', '%'.$request->q.'%')
                  ->orWhere('description', 'like', '%'.$request->q.'%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $categories = $query->orderBy('sort_order')->orderBy('name')->paginate(10)->withQueryString();

        $stats = [
            'total'   => Category::count(),
            'aktif'   => Category::where('is_active', true)->count(),
            'artikel' => Category::where('type', 'artikel')->count(),
            'jurnal'  => Category::where('type', 'jurnal')->count(),
            'materi'  => Category::where('type', 'materi')->count(),
        ];

        return view('admin.categories.index', compact('categories', 'stats'));
    }

    public function create()
    {
        return view('admin.categories.form', ['category' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string|max:500',
            'color'       => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'type'        => 'required|in:artikel,jurnal,materi',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'boolean',
        ]);

        $data['slug']      = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active', true);

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
            'name'        => ['required','string','max:100', Rule::unique('categories','name')->ignore($category->id)],
            'description' => 'nullable|string|max:500',
            'color'       => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'type'        => 'required|in:artikel,jurnal,materi',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
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

    public function toggleActive(Category $category)
    {
        $category->update(['is_active' => !$category->is_active]);
        return back()->with('success', 'Status kategori diperbarui.');
    }
}