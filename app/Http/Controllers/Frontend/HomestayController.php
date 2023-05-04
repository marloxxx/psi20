<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Homestay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Illuminate\Support\Facades\Validator;

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
        // update views
        $homestay->increment('views');
        // set meta title
        $this->setMeta($homestay->name);
        // get reviews from booking and homestay table
        $reviews = $homestay->reviews()->with('booking.user')->get();
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

    public function review(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'required|string|min:10|max:255',
            'homestay_id' => 'required|exists:homestays,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ]);
        }

        $homestay = Homestay::findOrFail($request->homestay_id);
        $user = User::findOrFail(auth()->user()->id);
        // check if user has booked this homestay
        if ($user->bookings()->where('homestay_id', $homestay->id)->exists()) {
            $user->reviews()->create([
                'rating' => $request->rating,
                'review' => $request->review,
                'booking_id' => $user->bookings()->where('homestay_id', $homestay->id)->first()->id,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Review added.',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'You have not booked this homestay.',
            ]);
        }
    }
}
