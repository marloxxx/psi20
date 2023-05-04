<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Booking;
use App\Models\Homestay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use App\Services\Midtrans\CallbackService;
use App\Services\Midtrans\CreateSnapTokenService;
use Carbon\Carbon;

class BookingController extends Controller
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

    public function check(Request $request)
    {
        $homestay = Homestay::findOrFail($request->homestay_id);
        $checkin = Carbon::parse($request->checkin);
        $checkout = Carbon::parse($request->checkout);
        // check if homestay is available
        if ($homestay->isAvailable($checkin, $checkout)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Homestay is available.'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Homestay is not available.'
            ]);
        }
    }
    public function create($id, Request $request)
    {
        $this->setMeta('Booking');
        $dates = explode(' > ', $request->dates);

        // parse from string to Carbon
        // create from this format 05-04-23 to 05-04-2023
        $checkin = Carbon::createFromFormat('m-d-y', $dates[0])->format('D, d M Y');
        $checkout = Carbon::createFromFormat('m-d-y', $dates[1])->format('D, d M Y');
        $homestay = Homestay::findOrFail($id);
        // total price = price * days
        $total = $homestay->price * $homestay->getDays($checkin, $checkout);

        return view('pages.frontend.booking.create', compact('homestay', 'checkin', 'checkout', 'total'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // dd(Carbon::parse($request->checkin)->format('Y-m-d'));
        $homestay = Homestay::findOrFail($request->homestay_id);
        $number = $homestay->bookings()->count() + 1;
        $booking = $homestay->bookings()->create([
            'code' => 'BOOK-' . $number,
            'check_in' => Carbon::parse($request->checkin)->format('Y-m-d'),
            'check_out' => Carbon::parse($request->checkout)->format('Y-m-d'),
            'total_price' => $request->total,
            'user_id' => auth()->user()->id,
        ]);
        return redirect()->route('booking.show', $booking->id);
    }

    public function show($id)
    {
        $booking = Booking::findOrFail($id);
        $this->setMeta('Booking #' . $booking->code);
        // $snapToken = $booking->snap_token;
        // if (empty($snapToken)) {
        // Jika snap token masih NULL, buat token snap dan simpan ke database

        //     $midtrans = new CreateSnapTokenService($booking);
        //     $snapToken = $midtrans->getSnapToken();

        //     $booking->snap_token = $snapToken;
        //     $booking->save();
        // }
        // dd($snapToken);
        return view('pages.frontend.booking.show', compact('booking', 'snapToken'));
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update([
            'status' => 'canceled',
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Booking cancelled.'
        ]);
    }
    public function callback()
    {
        $callback = new CallbackService;

        if ($callback->isSignatureKeyVerified()) {
            $notification = $callback->getNotification();
            $booking = $callback->getBooking();

            if ($callback->isSuccess()) {
                Booking::where('id', $booking->id)->update([
                    'payment_status' => '2',
                ]);
            }

            if ($callback->isExpire()) {
                Booking::where('id', $booking->id)->update([
                    'payment_status' => '3',
                ]);
            }

            if ($callback->isCancelled()) {
                Booking::where('id', $booking->id)->update([
                    'payment_status' => '4',
                ]);
            }

            return response()
                ->json([
                    'success' => true,
                    'message' => 'Notifikasi berhasil diproses',
                ]);
        } else {
            return response()
                ->json([
                    'error' => true,
                    'message' => 'Signature key tidak terverifikasi',
                ], 403);
        }
    }

    public function invoice($id)
    {
        $booking = Booking::findOrFail($id);
        $this->setMeta('Invoice #' . $booking->code);
        return view('pages.frontend.booking.invoice', compact('booking'));
    }
}
