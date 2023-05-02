<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('pages.frontend.event.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('pages.frontend.event.show', compact('event'));
    }
}
