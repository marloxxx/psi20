<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Facility;
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
            // dd($request->all());
            $range = explode(';', $request->range);
            // dd($range);
            $sort_price = $request->sort_price;
            $request_facilities = $request->facilities;
            $rating = $request->rating; // [3, 5]
            // get homestays with images and facilities based on price range, sort price, facilities, rating
            $homestays = Homestay::with('images', 'facilities')
                ->whereBetween('price_per_night', [$range[0], $range[1]])
                ->when($sort_price, function ($query, $sort_price) {
                    return $query->orderBy('price', $sort_price);
                })
                ->when($request_facilities, function ($query, $request_facilities) {
                    return $query->whereHas('facilities', function ($query) use ($request_facilities) {
                        return $query->whereIn('facility_id', $request_facilities);
                    });
                })
                ->when($rating, function ($query, $rating) {
                    return $query->whereHas('reviews', function ($query) use ($rating) {
                        return $query->whereIn('rating', $rating);
                    });
                })
                ->paginate(6);
            return view('pages.frontend.homestay.list', compact('homestays'))->render();
        }

        // get the lowest price and maximum price
        $min_price = Homestay::min('price_per_night');
        $max_price = Homestay::max('price_per_night');
        // dd($min_price, $max_price);
        // get facilities
        $facilities = Facility::limit(6)->get();
        $initialMarkers = [];
        $homestays = Homestay::all();
        foreach ($homestays as $homestay) {
            $initialMarkers[] = [
                'position' => [
                    'lat' => $homestay->latitude,
                    'lng' => $homestay->longitude,
                ],
                'label' => ['color' => 'black', 'text' => $homestay->name],
                'draggable' => true
            ];
        }
        return view('pages.frontend.homestay.index', compact('min_price', 'max_price', 'facilities', 'initialMarkers'));
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
        $initialMarkers = [
            [
                'position' => [
                    'lat' => $homestay->latitude,
                    'lng' => $homestay->longitude,
                ],
                'label' => ['color' => 'black', 'text' => $homestay->name],
                'draggable' => false
            ]
        ];
        return view('pages.frontend.homestay.show', compact('homestay', 'reviews', 'initialMarkers'));
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
                'message' => 'Penginapan dihapus dari favorit.'
            ]);
        } else {
            $user->wishlists()->attach($homestay->id);
            return response()->json([
                'status' => 'success',
                'action' => 'add',
                'message' => 'Penginapan ditambahkan ke favorit.'
            ]);
        }
    }

    public function review(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'required|string|min:10|max:255',
            'homestay_id' => 'required|exists:homestays,id',
        ], [
            'rating.required' => 'Rating tidak boleh kosong',
            'rating.numeric' => 'Rating harus berupa angka',
            'rating.min' => 'Rating minimal 1',
            'rating.max' => 'Rating maksimal 5',
            'review.required' => 'Review tidak boleh kosong',
            'review.string' => 'Review harus berupa string',
            'review.min' => 'Review minimal 10 karakter',
            'review.max' => 'Review maksimal 255 karakter',
            'homestay_id.required' => 'Homestay tidak boleh kosong',
            'homestay_id.exists' => 'Homestay tidak ditemukan',
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
        if (!$user->bookings()->where('homestay_id', $homestay->id)->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda belum pernah memesan penginapan ini.',
            ]);
        }
        // check if already reviewed
        if ($user->reviews()->where('booking_id', $user->bookings()->where('homestay_id', $homestay->id)->first()->id)->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda sudah pernah memberikan review.',
            ]);
        } else {
            $user->reviews()->create([
                'rating' => $request->rating,
                'review' => $request->review,
                'booking_id' => $user->bookings()->where('homestay_id', $homestay->id)->first()->id,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Review added.',
            ]);
        }
    }
}
