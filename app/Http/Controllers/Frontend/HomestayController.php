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
            $range = explode(';', $request->range);
            $sort_price = $request->sort_price;
            $request_facilities = $request->facilities;
            $rating = $request->rating;
            // get homestays with images and facilities based on price range, sort price, facilities, rating
            $homestays = Homestay::with('images', 'facilities')
                ->whereBetween('price_per_night', [$range[0], $range[1]])
                ->when($sort_price, function ($query, $sort_price) {
                    return $query->orderBy('price_per_night', $sort_price);
                })
                ->when($request_facilities, function ($query, $request_facilities) {
                    return $query->whereHas('facilities', function ($query) use ($request_facilities) {
                        return $query->whereIn('facility_id', $request_facilities);
                    });
                })
                ->when($rating, function ($query, $rating) {
                    return $query->where('rating', '>=', $rating);
                })
                ->latest()
                ->paginate(6);
            return view('pages.frontend.homestay.list', compact('homestays'))->render();
        }

        // get the lowest price and maximum price
        $min_price = Homestay::min('price_per_night');
        $max_price = Homestay::max('price_per_night');

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
        $homestay = Homestay::findOrFail($id)->load('images', 'facilities', 'owner', 'bookings');
        // update views
        $homestay->increment('views');
        // set meta title
        $this->setMeta($homestay->name);
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
        return view('pages.frontend.homestay.show', compact('homestay', 'initialMarkers'));
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
}
