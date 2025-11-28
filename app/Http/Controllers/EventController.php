<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view_events'); // Use specific permission
        $user = auth()->user();

        // Admin only sees their organization's events
        $events = Event::where('organization_id', $user->organization_id)
            ->latest()
            ->get();

        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('event.create'); // Use specific permission
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('event.create'); // Use specific permission
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'event_time' => 'required',
            'location' => 'required|string|max:255',
            'is_free' => 'required|boolean',
            'price' => 'required_if:is_free,false|nullable|integer|min:0',
        ]);

        $user = auth()->user();

        $event = Event::create([
            'organization_id' => $user->organization_id,
            'created_by' => $user->id,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'description' => $request->description,
            'event_date' => $request->event_date,
            'event_time' => $request->event_time,
            'location' => $request->location,
            'is_free' => $request->is_free,
            'price' => $request->is_free ? null : $request->price,
            'status' => 'pending',
        ]);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil diajukan. Menunggu persetujuan superadmin.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $this->authorize('event.view'); // Use specific permission
        $this->authorizeAccess($event);
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $this->authorize('event.update'); // Use specific permission
        $this->authorizeAccess($event);

        if ($event->status === 'published') {
            return back()->with('error', 'Event yang sudah dipublish tidak dapat diedit.');
        }

        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $this->authorize('event.update'); // Use specific permission
        $this->authorizeAccess($event);

        if ($event->status === 'published') {
            return back()->with('error', 'Event yang sudah dipublish tidak dapat diedit.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'event_time' => 'required',
            'location' => 'required|string|max:255',
            'is_free' => 'required|boolean',
            'price' => 'required_if:is_free,false|nullable|integer|min:0',
        ]);

        $event->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'description' => $request->description,
            'event_date' => $request->event_date,
            'event_time' => $request->event_time,
            'location' => $request->location,
            'is_free' => $request->is_free,
            'price' => $request->is_free ? null : $request->price,
            // If rejected, maybe reset to pending? User request didn't specify, but usually yes.
            // For now, let's keep status as is or reset to pending if it was rejected.
            'status' => $event->status === 'rejected' ? 'pending' : $event->status,
        ]);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $this->authorize('event.delete'); // Use specific permission
        $this->authorizeAccess($event);

        if ($event->status === 'published') {
            return back()->with('error', 'Event yang sudah dipublish tidak dapat dihapus.');
        }

        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dihapus.');
    }

    private function authorizeAccess(Event $event)
    {
        if ($event->organization_id !== auth()->user()->organization_id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
