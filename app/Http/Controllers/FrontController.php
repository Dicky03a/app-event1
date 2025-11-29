<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;


class FrontController extends Controller
{
      public function index()
      {
            $events = Event::where('status', 'published')
                  ->orderBy('event_date', 'asc')
                  ->paginate(6); // terserah mau berapa per halaman


            return view('public.events.index', compact('events'));
      }
}
