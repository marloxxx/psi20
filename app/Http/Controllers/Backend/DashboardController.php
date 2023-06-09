<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Homestay;
use App\Models\User;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;

class DashboardController extends Controller
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
    public function index()
    {
        $this->setMeta('Dashboard');
        $total_user = User::count();
        $total_homestay = 0;
        if (auth()->user()->role == 'admin') {
            $total_homestay = Homestay::count();
        } else if (auth()->user()->role == 'owner') {
            $total_homestay = Homestay::where('owner_id', auth()->user()->id)->count();
        }
        $total_event = Event::count();
        $total_booking = Booking::where('user_id', auth()->user()->id)->count();
        return view('pages.backend.dashboard.index', compact('total_user', 'total_homestay', 'total_event', 'total_booking'));
    }
}
