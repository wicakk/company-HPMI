<?php
namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\{LearningMaterial, Category};
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = LearningMaterial::with('category');

        // Non-premium hanya lihat materi gratis (is_member_only = false)
        if (!auth()->user()->isPremium()) {
            $query->where('is_member_only', false);
        }

        if ($request->filled('type'))     $query->where('type', $request->type);
        if ($request->filled('category')) $query->where('category_id', $request->category);
        if ($request->filled('search'))   $query->where('title', 'like', '%'.$request->search.'%');

        $materials  = $query->latest()->paginate(12);
        $categories = Category::where('type', 'material')->get();

        // Hitung jumlah materi premium yang terkunci (untuk banner)
        $lockedCount = auth()->user()->isPremium() ? 0 :
            LearningMaterial::where('is_member_only', true)->count();

        return view('member.materials.index', compact('materials', 'categories', 'lockedCount'));
    }

    public function show(int $id)
    {
        $material = LearningMaterial::findOrFail($id);

        // Cek akses
        if ($material->is_member_only && !auth()->user()->isPremium()) {
            return redirect()->route('member.materials')
                ->with('warning', 'Materi ini khusus anggota Premium. Upgrade akun Anda untuk mengaksesnya.');
        }

        $material->increment('views');
        return view('member.materials.show', compact('material'));
    }

    public function download(int $id)
    {
        $material = LearningMaterial::findOrFail($id);

        if ($material->is_member_only && !auth()->user()->isPremium()) {
            return back()->with('warning', 'Download khusus anggota Premium.');
        }

        if (!$material->file_url) return back()->with('error', 'File tidak tersedia.');
        $material->increment('downloads');
        return redirect($material->file_url);
    }
}
