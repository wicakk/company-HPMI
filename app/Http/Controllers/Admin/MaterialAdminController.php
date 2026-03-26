<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LearningMaterial;
use App\Models\Category;
use Illuminate\Http\Request;

class MaterialAdminController extends Controller
{
    public function index()
    {
        $materials = LearningMaterial::with('category')
            ->latest('id')
            ->paginate(15);

        return view('admin.materials.index', compact('materials'));
    }

    public function create()
    {
        $categories = Category::where('type', 'material')->get();

        return view('admin.materials.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'category_id'    => 'nullable|exists:categories,id',
            'file_url'       => 'nullable|url|required_if:type,pdf,module',
            'video_url'      => 'nullable|url|required_if:type,video',
            'type'           => 'required|in:pdf,video,article,module',
        ]);

        // Fix checkbox boolean
        $data['is_member_only'] = $request->boolean('is_member_only');

        // Set user
        $data['user_id'] = auth()->id();

        LearningMaterial::create($data);

        return redirect()
            ->route('admin.materials.index')
            ->with('success', 'Materi berhasil disimpan.');
    }

    public function show(LearningMaterial $materi)
    {
        return view('admin.materials.show', compact('materi'));
    }

    public function edit(LearningMaterial $materi)
    {
        $categories = Category::where('type', 'material')->get();

        return view('admin.materials.edit', compact('materi', 'categories'));
    }

    public function update(Request $request, LearningMaterial $materi)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'category_id'    => 'nullable|exists:categories,id',
            'file_url'       => 'nullable|url|required_if:type,pdf,module',
            'video_url'      => 'nullable|url|required_if:type,video',
            'type'           => 'required|in:pdf,video,article,module',
        ]);

        // Fix checkbox boolean
        $data['is_member_only'] = $request->boolean('is_member_only');

        $materi->update($data);

        return redirect()
            ->route('admin.materials.index')
            ->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy(LearningMaterial $materi)
    {
        $materi->delete();

        return back()->with('success', 'Materi berhasil dihapus.');
    }
}