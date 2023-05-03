<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Homestay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;

class HomestayController extends Controller
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

    public function index(Request $request)
    {
        $this->setMeta('Homestay');
        if ($request->ajax()) {
            // $homestays = Homestay::with('images')->paginate(6);
            return view('pages.frontend.homestay.list', [
                'homestays' => Homestay::with('images', 'facilities')->paginate(6)
            ])->render();
        }
        return view('pages.frontend.homestay.index');
    }

    public function show($id)
    {
        // get homestay with images, facilities
        $homestay = Homestay::findOrFail($id)->load('images', 'facilities');
        $this->setMeta($homestay->name);
        // get reviews from booking and homestay table
        $reviews = $homestay->bookings()->with('review')->get()->pluck('review')->merge($homestay->reviews);
        return view('pages.frontend.homestay.show', compact('homestay', 'reviews'));
    }

    public function toggle_wishlist(Request $request)
    {
        $homestay = Homestay::findOrFail($request->homestay_id);
        $user = User::findOrFail(auth()->user()->id);
        if ($user->wishlists()->where('homestay_id', $homestay->id)->exists()) {
            $user->wishlists()->detach($homestay->id);
            return response()->json([
                'status' => 'success',
                'action' => 'remove',
                'message' => 'Homestay removed from wishlist.'
            ]);
        } else {
            $user->wishlists()->attach($homestay->id);
            return response()->json([
                'status' => 'success',
                'action' => 'add',
                'message' => 'Homestay added to wishlist.'
            ]);
        }
    }
}
