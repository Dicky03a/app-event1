<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventApprovalController extends Controller
{
    /**
     * Display a listing of pending events.
     */
    public function index()
    {
        $this->authorize('event.approve'); // Use specific permission
        $events = Event::with(['organization', 'creator'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('super.events.index', compact('events'));
    }

    /**
     * Display the specified event for approval.
     */
    public function show(Event $event)
    {
        $this->authorize('event.approve'); // Use specific permission
        return view('super.events.show', compact('event'));
    }

    /**
     * Approve the event.
     */
    public function approve(Event $event)
    {
        $this->authorize('event.approve'); // Use specific permission
        $event->update([
            'status' => 'published',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => null,
        ]);

        return redirect()->route('super.events.pending')
            ->with('success', 'Event berhasil disetujui dan dipublish.');
    }

    /**
     * Reject the event.
     */
    public function reject(Request $request, Event $event)
    {
        $this->authorize('event.approve'); // Use specific permission
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $event->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'approved_by' => auth()->id(), // Track who rejected it
        ]);

        return redirect()->route('super.events.pending')
            ->with('success', 'Event berhasil ditolak.');
    }
}
