<?php

namespace App\Http\Controllers\Backend;

use App\Models\Booking;
use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;

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
            // get bookings where homestay owner is me
            $bookings = Booking::whereHas('homestay', function ($query) {
                $query->where('user_id', auth()->user()->id);
            })->with('homestay', 'user')->latest()->get();
            return datatables()->of($bookings)
                ->addColumn('checkbox', function ($booking) {
                    return '<input type="checkbox" name="id[]" value="' . $booking->id . '">';
                })
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
                    $action .= '</div>';
                    return $action;
                })
                ->addColumn('homestay', function ($booking) {
                    return $booking->homestay->name;
                })
                ->addColumn('user', function ($booking) {
                    return $booking->user->first_name . ' ' . $booking->user->last_name;
                })
                ->editColumn('check_in', function ($booking) {
                    return $booking->check_in->format('d F Y');
                })
                ->editColumn('check_out', function ($booking) {
                    return $booking->check_out->format('d F Y');
                })
                ->editColumn('status', function ($booking) {
                    return $booking->status();
                })
                ->editColumn('total', function ($booking) {
                    return 'Rp ' . number_format($booking->total_price, 0, ',', '.');
                })
                ->editColumn('payment_proof', function ($booking) {
                    return $booking->payment_proof ? '<a href="' . asset('images/payment-proofs/') . $booking->payment_proof . '" target="_blank">Lihat Bukti</a>' : '-';
                })
                ->rawColumns(['checkbox', 'action', 'homestay', 'user', 'check_in', 'check_out', 'status', 'total', 'payment_proof'])
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

    public function pdf()
    {
        $bookings = Booking::with('homestay', 'user')->get();
        $this->setMeta('Booking Detail');
        $pdf = PDF::loadView('pages.backend.bookings.pdf', compact('bookings'));
        return $pdf->download('booking.pdf');
    }
}
