<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;

class EventController extends Controller
{
    public function __construct()
    {
        SEOMeta::setTitleDefault(getSettings('site_name'));
        parent::__construct();
    }
    private function setMeta(string $title)
    {
        SEOMeta::setTitle($title);
        OpenGraph::setTitle(SEOMeta::getTitle());
        JsonLd::setTitle(SEOMeta::getTitle());
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->setMeta('Events');
        if ($request->ajax()) {
            $events = Event::latest()->with('images')->paginate(9);
            return view('pages.frontend.event.list', compact('events'))->render();
        }
        return view('pages.frontend.event.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $this->setMeta($event->title);
        return view('pages.frontend.event.show', compact('event'));
    }
}
