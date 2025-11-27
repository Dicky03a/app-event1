<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class PublicEventController extends Controller
{
    /**
     * Display a listing of published events.
     */
    public function index()
    {
        $events = Event::with('organization')
            ->published()
            ->latest()
            ->paginate(10);

        return view('public.events.index', compact('events'));
    }

    /**
     * Display the specified event.
     */
    public function show($slug)
    {
        $event = Event::with('organization')
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        return view('public.events.show', compact('event'));
    }
}
