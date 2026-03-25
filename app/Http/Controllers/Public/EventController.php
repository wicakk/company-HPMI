<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::where('status','!=','draft');
        if ($request->filled('search')) {
            $query->where('title','like','%'.$request->search.'%');
        }
        if ($request->filled('type')) {
            $query->where('is_member_only', $request->type === 'member');
        }
        $events = $query->orderBy('start_date')->paginate(9);
        return view('public.events.index', compact('events'));
    }

    public function show(string $slug)
    {
        $event = Event::where('slug',$slug)->where('status','!=','draft')->firstOrFail();
        $registered = false;
        if (auth()->check()) {
            $registered = $event->registrations()->where('user_id',auth()->id())->exists();
        }
        return view('public.events.show', compact('event','registered'));
    }
}
