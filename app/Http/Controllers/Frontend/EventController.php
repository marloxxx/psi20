<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
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
            $title = $request->title;
            if ($request->date != null) {
                $dates = explode(' > ', $request->date);
                // parse from string to Carbon
                // create from this format 05-04-23 to 05-04-2023
                $start_date = Carbon::createFromFormat('m-d-y', $dates[0]);
                $end_date = Carbon::createFromFormat('m-d-y', $dates[1]);
                // get events where start_date like $start_date and end_date like $end_date and title like $title
                $events = Event::whereBetween('start_date', [$start_date, $end_date])
                    ->whereBetween('end_date', [$start_date, $end_date])
                    ->where('title', 'like', '%' . $title . '%')
                    ->with('images')
                    ->paginate(6);
            } else {
                // get events where title is like $title
                $events = Event::where('title', 'like', '%' . $title . '%')
                    ->with('images')
                    ->paginate(6);
            }
            return view('pages.frontend.event.list', compact('events'))->render();
        }
        $initialMarkers = [];
        $events = Event::all();
        foreach ($events as $event) {
            $initialMarkers[] = [
                'position' => [
                    'lat' => $event->latitude,
                    'lng' => $event->longitude,
                ],
                'label' => ['color' => 'black', 'text' => $event->title],
                'draggable' => true
            ];
        }
        return view('pages.frontend.event.index', compact('initialMarkers'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $this->setMeta($event->title);

        // get the closest homestay from this event location based on distance by latitude and longitude
        $closestHomestays = $event->getClosestHomestays();
        $initialMarkers = [];

        // set the initial marker to the event location
        $initialMarkers[] = [
            'position' => [
                'lat' => $event->latitude,
                'lng' => $event->longitude,
            ],
            'label' => ['color' => 'black', 'text' => $event->title],
            'draggable' => true
        ];

        // set the initial marker to the closest homestay location
        foreach ($closestHomestays as $homestay) {
            $initialMarkers[] = [
                'position' => [
                    'lat' => $homestay->latitude,
                    'lng' => $homestay->longitude,
                ],
                'label' => ['color' => 'black', 'text' => $homestay->name],
                'draggable' => true
            ];
        }

        return view('pages.frontend.event.show', compact('event', 'initialMarkers', 'closestHomestays'));
    }
}
