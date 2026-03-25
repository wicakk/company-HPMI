<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventAdminController extends Controller
{
    public function index()
    {
        $events = Event::with('user')->latest()->paginate(15);
        return view('admin.events.index', compact('events'));
    }

    public function create() { return view('admin.events.create'); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'required|string',
            'location'       => 'nullable|string',
            'meeting_url'    => 'nullable|url',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after:start_date',
            'price'          => 'nullable|numeric|min:0',
            'is_member_only' => 'boolean',
            'is_free'        => 'boolean',
            'quota'          => 'nullable|integer|min:1',
            'status'         => 'required|in:draft,open,closed,completed',
        ]);
        $data['user_id'] = auth()->id();
        $data['slug']    = Str::slug($data['title']) . '-' . time();
        Event::create($data);
        return redirect()->route('admin.events.index')->with('success','Kegiatan berhasil disimpan.');
    }

    public function show(Event $kegiatan) { return view('admin.events.show', compact('kegiatan')); }

    public function edit(Event $kegiatan) { return view('admin.events.edit', compact('kegiatan')); }

    public function update(Request $request, Event $kegiatan)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'required|string',
            'location'       => 'nullable|string',
            'meeting_url'    => 'nullable|url',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after:start_date',
            'price'          => 'nullable|numeric|min:0',
            'is_member_only' => 'boolean',
            'is_free'        => 'boolean',
            'quota'          => 'nullable|integer|min:1',
            'status'         => 'required|in:draft,open,closed,completed',
        ]);
        $kegiatan->update($data);
        return redirect()->route('admin.events.index')->with('success','Kegiatan berhasil diperbarui.');
    }

    public function destroy(Event $kegiatan)
    {
        $kegiatan->delete();
        return back()->with('success','Kegiatan berhasil dihapus.');
    }
}
