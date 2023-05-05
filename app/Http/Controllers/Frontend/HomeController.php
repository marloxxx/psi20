<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Event;
use App\Models\Facility;
use App\Models\Homestay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;

class HomeController extends Controller
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
     * Show the home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->setMeta('Home');
        // get popular homestays
        $popular_homestays = Homestay::with('images')->orderBy('views', 'desc')->get();
        // get latest events
        $events = Event::with('images')->orderBy('created_at', 'desc')->get();
        // get facilities
        $facilities = Facility::limit(6)->get();
        return view('pages.frontend.home.index', compact('popular_homestays', 'events', 'facilities'));
    }
}
