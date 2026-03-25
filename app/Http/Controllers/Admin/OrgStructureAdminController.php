<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationStructure;
use Illuminate\Http\Request;

class OrgStructureAdminController extends Controller
{
    public function index() { return view('admin.org.index', ['structures' => OrganizationStructure::ordered()->paginate(20)]); }
    public function create() { return view('admin.org.create'); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'position'    => 'required|string|max:255',
            'photo'       => 'nullable|string',
            'bio'         => 'nullable|string',
            'period'      => 'required|string|max:20',
            'order_index' => 'nullable|integer',
            'is_active'   => 'boolean',
        ]);
        OrganizationStructure::create($data);
        return redirect()->route('admin.org.index')->with('success','Data pengurus disimpan.');
    }

    public function show(OrganizationStructure $strukturOrganisasi) { return view('admin.org.show', ['structure' => $strukturOrganisasi]); }
    public function edit(OrganizationStructure $strukturOrganisasi) { return view('admin.org.edit', ['structure' => $strukturOrganisasi]); }

    public function update(Request $request, OrganizationStructure $strukturOrganisasi)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255', 'position' => 'required|string|max:255',
            'period' => 'required|string|max:20', 'order_index' => 'nullable|integer', 'is_active' => 'boolean',
        ]);
        $strukturOrganisasi->update($data);
        return redirect()->route('admin.org.index')->with('success','Data pengurus diperbarui.');
    }

    public function destroy(OrganizationStructure $strukturOrganisasi)
    {
        $strukturOrganisasi->delete();
        return back()->with('success','Data pengurus dihapus.');
    }
}
