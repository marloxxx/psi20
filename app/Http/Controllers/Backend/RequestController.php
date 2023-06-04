<?php

namespace App\Http\Controllers\Backend;

use App\Models\Homestay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Yajra\DataTables\Facades\DataTables;
use App\Notifications\ApproveBookingNotification;
use App\Notifications\ApprovedHomestayNotification;

class RequestController extends Controller
{
    private $message;
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
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->setMeta('Homestay');
        if ($request->ajax()) {
            return DataTables::of(Homestay::where('owner_id', '!=', auth()->user()->id)->with('facilities', 'owner')->get())
                ->addColumn('checkbox', function ($data) {
                    return '<input type="checkbox" name="id[]" value="' . $data->id . '" onclick="check(this)" />';
                })
                ->addColumn('action', function ($data) {
                    if ($data->is_approved == 'pending') {
                        return '<div class="btn-group" role="group">
                                <a href="javascript:;" onclick="handle_confirm(\'Apakah Anda Yakin?\',\'Yakin\',\'Tidak\',\'PUT\',\'' . route('backend.requests.approve', $data->id) . '\');" class="btn btn-primary">
                                    Approve
                                </a>
                                <a href="javascript:;" onclick="handle_confirm(\'Apakah Anda Yakin?\',\'Yakin\',\'Tidak\',\'PUT\',\'' . route('backend.requests.reject', $data->id) . '\');" class="btn btn-danger">
                                    Reject
                                </a>
                            </div>';
                    } else if ($data->is_approved == 'approved') {
                        return '<span class="badge badge-success">Sudah diapprove</span>';
                    } else if ($data->is_approved == 'rejected') {
                        return '<span class="badge badge-danger">Sudah ditolak</span>';
                    }
                })
                ->addColumn('facilities', function ($data) {
                    $facilities = '';
                    foreach ($data->facilities as $facility) {
                        $facilities .= '<span class="badge badge-primary me-1">' . $facility->name . '</span>';
                    }
                    return $facilities;
                })
                ->editColumn('is_available', function ($data) {
                    return $data->is_available ? '<span class="badge badge-success">Tersedia</span>' : '<span class="badge badge-danger">Tidak Tersedia</span>';
                })
                ->rawColumns(['action', 'checkbox', 'facilities', 'is_available'])
                ->make(true);
        }
        return view('pages.backend.requests.index');
    }

    public function approve(Homestay $homestay)
    {
        $homestay->is_approved = 'approved';
        $homestay->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengapprove homestay'
        ]);
    }

    public function reject(Homestay $homestay)
    {
        $homestay->is_approved = 'rejected';
        $homestay->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menolak homestay'
        ]);
    }
}
