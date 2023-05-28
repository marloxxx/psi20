<?php

namespace App\Http\Controllers\Backend;

use App\Models\Homestay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Yajra\DataTables\Facades\DataTables;

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
            return DataTables::of(Homestay::where('owner_id', '!=', auth()->user()->id)->with('facilities')->get())
                ->addColumn('checkbox', function ($data) {
                    return '<input type="checkbox" name="id[]" value="' . $data->id . '">';
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group" role="group">
                    <a href="javascript:;" onclick="handle_confirm(\'Apakah Anda Yakin?\',\'Yakin\',\'Tidak\',\'PUT\',\'' . route('backend.requests.approve', $data->id) . '\');" class="btn btn-primary">
                        Approve
                    </a>
                    <a href="javascript:;" onclick="handle_confirm(\'Apakah Anda Yakin?\',\'Yakin\',\'Tidak\',\'PUT\',\'' . route('backend.requests.reject', $data->id) . '\');" class="btn btn-danger">
                        Reject
                    </a>
                </div>';
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Homestay $homestay)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Homestay $homestay)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Homestay $homestay)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Homestay $homestay)
    {
        //
    }
}
