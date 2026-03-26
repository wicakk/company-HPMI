<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventAdminController extends Controller
{
    public function index()
    {
        $events = Event::with('user')->latest()->paginate(15);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'location'       => 'nullable|string|max:255',
            'meeting_url'    => 'nullable|url|max:500',
            'start_date'     => 'required|date',
            'end_date'       => 'nullable|date|after:start_date',
            'price'          => 'nullable|numeric|min:0',
            'is_member_only' => 'nullable|boolean',
            'is_free'        => 'nullable|boolean',
            'quota'          => 'nullable|integer|min:1',
            'status'         => 'required|in:draft,open,closed,completed',
            'thumbnail'      => 'nullable|string|max:500',          // URL tab
            'thumbnail_file' => 'nullable|image|mimes:jpeg,png,webp,gif|max:5120', // File tab (max 5MB)
        ]);

        // Normalise checkbox booleans (unchecked = not sent)
        $data['is_free']        = $request->boolean('is_free');
        $data['is_member_only'] = $request->boolean('is_member_only');

        // File upload takes priority over URL string
        if ($request->hasFile('thumbnail_file')) {
            $path = $request->file('thumbnail_file')->store('events/thumbnails', 'public');
            $data['thumbnail'] = Storage::url($path);
        } elseif (empty($data['thumbnail'])) {
            unset($data['thumbnail']);
        }

        $data['user_id'] = auth()->id();
        $data['slug']    = Str::slug($data['title']) . '-' . time();

        Event::create($data);

        return redirect()->route('admin.events.index')
                         ->with('success', 'Kegiatan berhasil disimpan.');
    }

    public function show(Event $kegiatan)
    {
        return view('admin.events.show', compact('kegiatan'));
    }

    public function edit(Event $kegiatan)
    {
        $event = $kegiatan; // rename to match view
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $kegiatan)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'location'       => 'nullable|string|max:255',
            'meeting_url'    => 'nullable|url|max:500',
            'start_date'     => 'required|date',
            'end_date'       => 'nullable|date|after:start_date',
            'price'          => 'nullable|numeric|min:0',
            'is_member_only' => 'nullable|boolean',
            'is_free'        => 'nullable|boolean',
            'quota'          => 'nullable|integer|min:1',
            'status'         => 'required|in:draft,open,closed,completed',
            'thumbnail'      => 'nullable|string|max:500',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,png,webp,gif|max:5120',
        ]);

        $data['is_free']        = $request->boolean('is_free');
        $data['is_member_only'] = $request->boolean('is_member_only');

        if ($request->hasFile('thumbnail_file')) {
            // Delete old stored file (not external URLs)
            if ($kegiatan->thumbnail && Str::startsWith($kegiatan->thumbnail, '/storage/')) {
                Storage::disk('public')->delete(Str::after($kegiatan->thumbnail, '/storage/'));
            }
            $path = $request->file('thumbnail_file')->store('events/thumbnails', 'public');
            $data['thumbnail'] = Storage::url($path);
        } elseif (empty($data['thumbnail'])) {
            // Keep existing thumbnail if neither file nor URL was provided
            unset($data['thumbnail']);
        }

        $kegiatan->update($data);

        return redirect()->route('admin.events.index')
                         ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Event $kegiatan)
    {
        // Clean up stored file
        if ($kegiatan->thumbnail && Str::startsWith($kegiatan->thumbnail, '/storage/')) {
            Storage::disk('public')->delete(Str::after($kegiatan->thumbnail, '/storage/'));
        }

        $kegiatan->delete();

        return redirect()->route('admin.events.index')->with('success', 'Kegiatan berhasil dihapus.');
    }
}