<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Homestay;
use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\CompleteBookingNotification;
use App\Notifications\NewBookingNotification;
use App\Notifications\UpdatePaymentNotification;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Illuminate\Support\Facades\Validator;

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
                'message' => 'Penginapan tersedia.'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Penginapan tidak tersedia.'
            ]);
        }
    }
    public function create($id, Request $request)
    {
        $this->setMeta('Booking');
        $dates = explode(' > ', $request->dates);

        // parse from string to Carbon
        // create from this format 05-04-23 to 05-04-2023
        $adults = $request->adults;
        $children = $request->children;
        $checkin = Carbon::createFromFormat('m-d-y', $dates[0])->format('D, d M Y');
        $checkout = Carbon::createFromFormat('m-d-y', $dates[1])->format('D, d M Y');
        $homestay = Homestay::findOrFail($id);
        // total price = price * days
        $total = $homestay->price_per_night * $homestay->getDays($checkin, $checkout);

        return view('pages.frontend.booking.create', compact('homestay', 'adults', 'children', 'checkin', 'checkout', 'total'));
    }

    public function store(Request $request)
    {
        $homestay = Homestay::findOrFail($request->homestay_id);
        // get last booking number, if null set to 1
        $number = Booking::count() ? Booking::latest()->first()->id + 1 : 1;
        $booking = $homestay->bookings()->create([
            'code' => 'BOOK-' . $number,
            'adults' => $request->adults,
            'children' => $request->children,
            'check_in' => Carbon::parse($request->checkin)->format('Y-m-d'),
            'check_out' => Carbon::parse($request->checkout)->format('Y-m-d'),
            'total_price' => $request->total,
            'user_id' => auth()->user()->id,
        ]);

        $booking->homestay->save();

        return redirect()->route('booking.show', $booking->id)->with('success', 'Pemesanan berhasil dibuat.');
    }

    public function show($id)
    {
        $booking = Booking::findOrFail($id)->load('homestay', 'user');
        $this->setMeta('Booking #' . $booking->code);
        return view('pages.frontend.booking.show', compact('booking'));
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update([
            'status' => 'canceled',
        ]);

        $booking->homestay->is_available = true;

        return response()->json([
            'status' => 'success',
            'message' => 'Pemesanan berhasil dibatalkan.'
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Bukti pembayaran tidak valid.'
            ], 422);
        }
        $booking = Booking::findOrFail($id);
        $number = $booking->id;
        $file = $request->file('file');
        $fileName = 'PAYMENT-PROOF-' . $number . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/payment-proofs'), $fileName);
        $booking = Booking::findOrFail($id);

        $booking->update([
            'payment_status' => '1', // '1' = 'pending
            'payment_proof' => $fileName,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pemesanan berhasil diselesaikan.'
        ]);
    }

    public function invoice($id)
    {
        $booking = Booking::findOrFail($id);
        $this->setMeta('Invoice #' . $booking->code);
        return view('pages.frontend.booking.invoice', compact('booking'));
    }

    public function download($id)
    {
        $booking = Booking::findOrFail($id);
        $pdf = PDF::loadView('pages.frontend.booking.pdf', compact('booking'));
        return $pdf->download('invoice-' . $booking->code . '.pdf');
    }

    public function review(Request $request, $id)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'required|string|min:10|max:255',
        ], [
            'rating.required' => 'Rating tidak boleh kosong',
            'rating.numeric' => 'Rating harus berupa angka',
            'rating.min' => 'Rating minimal 1',
            'rating.max' => 'Rating maksimal 5',
            'review.required' => 'Review tidak boleh kosong',
            'review.string' => 'Review harus berupa string',
            'review.min' => 'Review minimal 10 karakter',
            'review.max' => 'Review maksimal 255 karakter',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ]);
        }

        $booking = Booking::findOrFail($id);
        $booking->update([
            'status' => 'completed',
            'rating' => $request->rating,
            'review' => $request->review,
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Review added.',
        ]);
    }
}
