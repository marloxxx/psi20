<?php

namespace App\Http\Controllers\Backend;

use PDF;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use App\Notifications\CancelBookingNotification;
use App\Notifications\RejectBookingNotification;
use App\Notifications\ApproveBookingNotification;
use App\Notifications\CompleteBookingNotification;
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
    public function index(Request $request)
    {
        $this->setMeta('Pemesanan');
        if ($request->ajax()) {
            // get bookings where homestay owner is auth user
            $bookings = Booking::with('homestay', 'user')->whereHas('homestay', function ($query) {
                $query->where('owner_id', auth()->user()->id);
            })->latest('created_at')->get();
            return datatables()->of($bookings)
                ->addColumn('action', function ($booking) {

                    $action = '<div class="btn-group" role="group">
                                <a href="' . route('backend.bookings.show', $booking->id) . '" class="btn btn-primary">Detail</a>';
                    if ($booking->payment_status == '1' && $booking->payment_proof != null) {
                        $action .=  '<a href="javascript:;" onclick="handle_confirm(\'Apakah Anda Yakin?\',\'Yakin\',\'Tidak\',\'PUT\',\'' . route('backend.bookings.approve', $booking->id) . '\');" class="btn btn-success">
                                Setujui
                                </a>
                                <a href="javascript:;" onclick="handle_confirm(\'Apakah Anda Yakin?\',\'Yakin\',\'Tidak\',\'PUT\',\'' . route('backend.bookings.reject', $booking->id) . '\');" class="btn btn-danger">
                                    Tolak
                                </a>';
                    }
                    // if booking status is approved
                    if ($booking->status == 'approved' && Carbon::now()->format('Y-m-d') >= $booking->check_out) {
                        $action .=  '<a href="javascript:;" onclick="handle_confirm(\'Apakah Anda Yakin?\',\'Yakin\',\'Tidak\',\'PUT\',\'' . route('backend.bookings.complete', $booking->id) . '\');" class="btn btn-success">
                                Selesaikan
                            </a>';
                    }
                    $action .= '</div>';
                    return $action;
                })
                ->addColumn('homestay', function ($booking) {
                    return $booking->homestay->name;
                })
                ->addColumn('user', function ($booking) {
                    return $booking->user->first_name . ' ' . $booking->user->last_name;
                })
                ->editColumn('total', function ($booking) {
                    return 'Rp ' . number_format($booking->total_price, 0, ',', '.');
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.backend.bookings.index');
    }

    public function show(Booking $booking)
    {
        $this->setMeta('Detail Pemesanan');
        return view('pages.backend.bookings.show', compact('booking'));
    }

    public function approve(Booking $booking)
    {
        $booking->update([
            'is_available' => false,
            'status' => Booking::STATUS_APPROVED,
            'payment_status' => '2',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengubah status booking'
        ]);
    }

    public function reject(Booking $booking)
    {
        $booking->update([
            'status' => Booking::STATUS_REJECTED,
            'payment_status' => '3',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengubah status booking'
        ]);
    }

    public function cancel(Booking $booking)
    {
        $booking->update([
            'status' => Booking::STATUS_CANCELED,
            'payment_status' => '4',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengubah status booking'
        ]);
    }

    public function complete(Booking $booking)
    {
        $booking->update([
            'is_available' => true,
            'status' => Booking::STATUS_COMPLETED,
            'payment_status' => '5',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengubah status booking'
        ]);
    }

    public function pdf()
    {
        $bookings = Booking::with('homestay', 'user')->get();
        $this->setMeta('Booking Detail');
        $pdf = PDF::loadView('pages.backend.bookings.pdf', compact('bookings'));
        return $pdf->download('booking.pdf');
    }
}
