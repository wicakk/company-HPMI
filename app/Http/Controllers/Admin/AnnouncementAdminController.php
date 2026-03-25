<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementAdminController extends Controller
{
    public function index() { return view('admin.announcements.index', ['announcements' => Announcement::with('user')->latest()->paginate(15)]); }
    public function create() { return view('admin.announcements.create'); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'content'        => 'required|string',
            'type'           => 'required|string',
            'is_pinned'      => 'boolean',
            'is_member_only' => 'boolean',
            'published_at'   => 'nullable|date',
            'expired_at'     => 'nullable|date',
        ]);
        $data['user_id'] = auth()->id();
        Announcement::create($data);
        return redirect()->route('admin.announcements.index')->with('success','Pengumuman disimpan.');
    }

    public function show(Announcement $pengumuman) { return view('admin.announcements.show', compact('pengumuman')); }
    public function edit(Announcement $pengumuman) { return view('admin.announcements.edit', compact('pengumuman')); }

    public function update(Request $request, Announcement $pengumuman)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'content'        => 'required|string',
            'type'           => 'required|string',
            'is_pinned'      => 'boolean',
            'is_member_only' => 'boolean',
        ]);
        $pengumuman->update($data);
        return redirect()->route('admin.announcements.index')->with('success','Pengumuman diperbarui.');
    }

    public function destroy(Announcement $pengumuman)
    {
        $pengumuman->delete();
        return back()->with('success','Pengumuman dihapus.');
    }
}
