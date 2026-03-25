<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{LearningMaterial, Category};
use Illuminate\Http\Request;

class MaterialAdminController extends Controller
{
    public function index() { return view('admin.materials.index', ['materials' => LearningMaterial::with('category')->latest()->paginate(15)]); }
    public function create() { return view('admin.materials.create', ['categories' => Category::where('type','material')->get()]); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'category_id'    => 'nullable|exists:categories,id',
            'file_url'       => 'nullable|url',
            'video_url'      => 'nullable|url',
            'type'           => 'required|in:pdf,video,article,module',
            'is_member_only' => 'boolean',
        ]);
        $data['user_id'] = auth()->id();
        LearningMaterial::create($data);
        return redirect()->route('admin.materials.index')->with('success','Materi disimpan.');
    }

    public function show(LearningMaterial $materi) { return view('admin.materials.show', compact('materi')); }
    public function edit(LearningMaterial $materi) { return view('admin.materials.edit', ['materi' => $materi, 'categories' => Category::where('type','material')->get()]); }

    public function update(Request $request, LearningMaterial $materi)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'category_id'    => 'nullable|exists:categories,id',
            'file_url'       => 'nullable|url',
            'video_url'      => 'nullable|url',
            'type'           => 'required|in:pdf,video,article,module',
            'is_member_only' => 'boolean',
        ]);
        $materi->update($data);
        return redirect()->route('admin.materials.index')->with('success','Materi diperbarui.');
    }

    public function destroy(LearningMaterial $materi) { $materi->delete(); return back()->with('success','Materi dihapus.'); }
}
