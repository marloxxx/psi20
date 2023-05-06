<?php

namespace App\Http\Controllers\Backend;

use App\Models\Facility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class FacilityController extends Controller
{
    private $message;
    public function __construct()
    {
        SEOMeta::setTitleDefault(getSettings('site_name'));
        parent::__construct();
        $this->message = [
            'name.required' => 'Nama tidak boleh kosong',
        ];
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
        $this->setMeta('Facilities');
        if ($request->ajax()) {
            return DataTables::of(Facility::query())
                ->addColumn('checkbox', function ($data) {
                    return '<input type="checkbox" name="id[]" value="' . $data->id . '">';
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group" role="group">
                        <a href="' . route('backend.facilities.edit', $data->id) . '" class="btn btn-warning">
                            <i class="fas fa-solid fa-pen-to-square"></i>
                        </a>
                        <a href="javascript:;" onclick="handle_confirm(\'Apakah Anda Yakin?\',\'Yakin\',\'Tidak\',\'DELETE\',\'' . route('backend.facilities.destroy', $data->id) . '\');" class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>';
                })
                ->rawColumns(['action', 'checkbox'])
                ->make(true);
        }
        return view('pages.backend.facilities.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.backend.facilities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required',
        ], $this->message);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ]);
        }

        Facility::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menambahkan fasilitas',
            'redirect' => route('backend.facilities.index')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Facility $facility)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Facility $facility)
    {
        return view('pages.backend.facilities.edit', compact('facility'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Facility $facility)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required',
        ], $this->message);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ]);
        }

        $facility->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengubah fasilitas',
            'redirect' => route('backend.facilities.index')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facility $facility)
    {
        $facility->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus fasilitas'
        ]);
    }
}
