<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LayananController extends Controller
{
    // ── Index ─────────────────────────────────────────────────────────────────
    public function index(Request $request): View
    {
        $query = Layanan::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('kategori', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $layanans = $query->orderBy('urutan')->orderBy('nama')->paginate(10)->withQueryString();

        return view('admin.layanan.index', compact('layanans'));
    }

    // ── Create ────────────────────────────────────────────────────────────────
    public function create(): View
    {
        $kategoriOptions = ['Darurat', 'Rawat Inap', 'Poliklinik', 'Lainnya'];
        return view('admin.layanan.create', compact('kategoriOptions'));
    }

    // ── Store ─────────────────────────────────────────────────────────────────
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama'              => 'required|string|max:255',
            'ikon'              => 'nullable|string|max:10',
            'deskripsi_singkat' => 'required|string|max:500',
            'deskripsi_lengkap' => 'nullable|string',
            'kategori'          => 'required|in:Darurat,Rawat Inap,Poliklinik,Lainnya',
            'urutan'            => 'required|integer|min:0',
            'status'            => 'required|in:aktif,nonaktif',
            'gambar'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('layanan', 'public');
        }

        Layanan::create($validated);

        return redirect()->route('admin.layanan.index')
                         ->with('success', 'Layanan berhasil ditambahkan.');
    }

    // ── Edit ──────────────────────────────────────────────────────────────────
    public function edit(Layanan $layanan): View
    {
        $kategoriOptions = ['Darurat', 'Rawat Inap', 'Poliklinik', 'Lainnya'];
        return view('admin.layanan.edit', compact('layanan', 'kategoriOptions'));
    }

    // ── Update ────────────────────────────────────────────────────────────────
    public function update(Request $request, Layanan $layanan): RedirectResponse
    {
        $validated = $request->validate([
            'nama'              => 'required|string|max:255',
            'ikon'              => 'nullable|string|max:10',
            'deskripsi_singkat' => 'required|string|max:500',
            'deskripsi_lengkap' => 'nullable|string',
            'kategori'          => 'required|in:Darurat,Rawat Inap,Poliklinik,Lainnya',
            'urutan'            => 'required|integer|min:0',
            'status'            => 'required|in:aktif,nonaktif',
            'gambar'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($layanan->gambar) {
                Storage::disk('public')->delete($layanan->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('layanan', 'public');
        }

        $layanan->update($validated);

        return redirect()->route('admin.layanan.index')
                         ->with('success', 'Layanan berhasil diperbarui.');
    }

    // ── Destroy ───────────────────────────────────────────────────────────────
    public function destroy(Layanan $layanan): RedirectResponse
    {
        if ($layanan->gambar) {
            Storage::disk('public')->delete($layanan->gambar);
        }

        $layanan->delete();

        return redirect()->route('admin.layanan.index')
                         ->with('success', 'Layanan berhasil dihapus.');
    }

    // ── Toggle Status (AJAX) ──────────────────────────────────────────────────
    public function toggleStatus(Layanan $layanan)
    {
        $layanan->update([
            'status' => $layanan->status === 'aktif' ? 'nonaktif' : 'aktif',
        ]);

        return response()->json([
            'success' => true,
            'status'  => $layanan->status,
            'label'   => $layanan->status_label,
        ]);
    }

    // ── Update Urutan (drag & drop order) ────────────────────────────────────
    public function updateUrutan(Request $request)
    {
        $request->validate([
            'items'       => 'required|array',
            'items.*.id'  => 'required|exists:layanans,id',
            'items.*.urutan' => 'required|integer',
        ]);

        foreach ($request->items as $item) {
            Layanan::where('id', $item['id'])->update(['urutan' => $item['urutan']]);
        }

        return response()->json(['success' => true]);
    }
}
