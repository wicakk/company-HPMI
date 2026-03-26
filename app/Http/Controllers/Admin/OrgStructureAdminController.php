<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrgStructureAdminController extends Controller
{
    public function index()
    {
        $structures = OrganizationStructure::orderBy('order_index')->orderBy('id')->paginate(20);
        return view('admin.org.index', compact('structures'));
    }

    public function create()
    {
        return view('admin.org.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'position'    => 'required|string|max:255',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'bio'         => 'nullable|string|max:1000',
            'period'      => 'nullable|string|max:20',
            'order_index' => 'nullable|integer|min:0',
            'is_active'   => 'nullable|in:0,1',
        ]);

        // Upload foto
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')
                ->store('org/photos', 'public');
        }

        $data['is_active'] = $request->boolean('is_active', true);

        OrganizationStructure::create($data);

        return redirect()->route('admin.org.index')
            ->with('success', 'Data pengurus berhasil disimpan.');
    }

    public function show(OrganizationStructure $strukturOrganisasi)
    {
        return view('admin.org.show', ['structure' => $strukturOrganisasi]);
    }

    public function edit(OrganizationStructure $strukturOrganisasi)
    {
        return view('admin.org.edit', ['structure' => $strukturOrganisasi]);
    }

    public function update(Request $request, OrganizationStructure $strukturOrganisasi)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'position'     => 'required|string|max:255',
            'photo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'bio'          => 'nullable|string|max:1000',
            'period'       => 'nullable|string|max:20',
            'order_index'  => 'nullable|integer|min:0',
            'is_active'    => 'nullable|in:0,1',
            'remove_photo' => 'nullable|in:0,1',
        ]);

        // Hapus foto jika diminta
        if ($request->input('remove_photo') === '1' && $strukturOrganisasi->photo) {
            Storage::disk('public')->delete($strukturOrganisasi->photo);
            $data['photo'] = null;
        }

        // Upload foto baru
        if ($request->hasFile('photo')) {
            if ($strukturOrganisasi->photo) {
                Storage::disk('public')->delete($strukturOrganisasi->photo);
            }
            $data['photo'] = $request->file('photo')
                ->store('org/photos', 'public');
        }

        $data['is_active'] = $request->boolean('is_active');
        unset($data['remove_photo']);

        $strukturOrganisasi->update($data);

        return redirect()->route('admin.org.index')
            ->with('success', 'Data pengurus berhasil diperbarui.');
    }

    public function destroy(OrganizationStructure $strukturOrganisasi)
    {
        if ($strukturOrganisasi->photo) {
            Storage::disk('public')->delete($strukturOrganisasi->photo);
        }

        $strukturOrganisasi->delete();

        return back()->with('success', 'Data pengurus berhasil dihapus.');
    }
}