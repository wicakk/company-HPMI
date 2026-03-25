<?php
namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\{Event, EventRegistration};
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        // Tampilkan event yang open ATAU upcoming (bukan draft/completed)
        $events = Event::whereIn('status', ['open', 'closed'])
            ->with(['registrations'])
            ->orderBy('start_date')
            ->paginate(9);

        return view('member.events.index', compact('events'));
    }

    public function show(int $id)
    {
        $event      = Event::with('registrations')->findOrFail($id);
        $registered = $event->registrations()->where('user_id', auth()->id())->exists();
        return view('member.events.show', compact('event', 'registered'));
    }

    public function register(int $id)
    {
        $event = Event::findOrFail($id);
        if ($event->status !== 'open') {
            return back()->with('error', 'Pendaftaran kegiatan ini sudah ditutup.');
        }
        if ($event->isQuotaFull()) {
            return back()->with('error', 'Kuota pendaftaran sudah penuh.');
        }
        $exists = $event->registrations()->where('user_id', auth()->id())->exists();
        if ($exists) {
            return back()->with('info', 'Anda sudah terdaftar pada kegiatan ini.');
        }
        EventRegistration::create([
            'event_id' => $id,
            'user_id'  => auth()->id(),
            'status'   => 'confirmed',
        ]);
        return back()->with('success', 'Pendaftaran berhasil!');
    }

    public function cancel(int $id)
    {
        EventRegistration::where('event_id', $id)
            ->where('user_id', auth()->id())
            ->delete();
        return back()->with('success', 'Pendaftaran dibatalkan.');
    }
}
