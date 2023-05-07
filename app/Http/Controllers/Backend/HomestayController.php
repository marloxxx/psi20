<?php

namespace App\Http\Controllers\Backend;

use App\Models\Image;
use App\Models\Facility;
use App\Models\Homestay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class HomestayController extends Controller
{
    private $message;
    public function __construct()
    {
        SEOMeta::setTitleDefault(getSettings('site_name'));
        parent::__construct();
        $this->message = [
            'name.required' => 'Nama tidak boleh kosong',
            'is_available.required' => 'Status tidak boleh kosong',
            'facilities.required' => 'Fasilitas tidak boleh kosong',
            'description.required' => 'Deskripsi tidak boleh kosong',
            'price.required' => 'Harga tidak boleh kosong',
            'price.numeric' => 'Harga harus berupa angka',
            'capacity.required' => 'Kapasitas tidak boleh kosong',
            'capacity.numeric' => 'Kapasitas harus berupa angka',
            'address.required' => 'Alamat tidak boleh kosong',
            'latitude.required' => 'Latitude tidak boleh kosong',
            'longitude.required' => 'Longitude tidak boleh kosong',
            'image.required' => 'Gambar tidak boleh kosong',
            'image.image' => 'Gambar harus berupa file gambar',
            'image.mimes' => 'Gambar harus berupa file gambar',
            'image.max' => 'Gambar maksimal 2MB',
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
        $this->setMeta('Homestay');
        if ($request->ajax()) {
            return DataTables::of(Homestay::where('owner_id', auth()->user()->id)->with('facilities')->get())
                ->addColumn('checkbox', function ($data) {
                    return '<input type="checkbox" name="id[]" value="' . $data->id . '">';
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group" role="group">
                    <a href="' . route('backend.homestays.edit', $data->id) . '" class="btn btn-warning">
                        <i class="fas fa-solid fa-pen-to-square"></i>
                    </a>
                    <a href="javascript:;" onclick="handle_confirm(\'Apakah Anda Yakin?\',\'Yakin\',\'Tidak\',\'DELETE\',\'' . route('backend.homestays.destroy', $data->id) . '\');" class="btn btn-danger">
                        <i class="fa fa-trash"></i>
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
        return view('pages.backend.homestays.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->setMeta('Tambah Homestay');
        $facilities = Facility::all();
        return view('pages.backend.homestays.create', compact('facilities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'is_available' => 'required',
            'facilities' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'capacity' => 'required|numeric',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], $this->message);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ]);
        }

        $homestay = Homestay::create([
            'owner_id' => auth()->user()->id,
            'name' => $request->name,
            'is_available' => $request->is_available,
            'description' => $request->description,
            'price' => $request->price,
            'capacity' => $request->capacity,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ], $this->message);

        $homestay->facilities()->attach($request->facilities);

        $imageName = (time() + rand(1, 100)) . '.' . $request->image->extension();
        $size = $request->file('image')->getSize();
        $request->image->move(public_path('images/homestays'), $imageName);

        $homestay->images()->create([
            'name' => $imageName,
            'size' => $size,
            'image_path' => "images/homestays/" . $imageName,
            'is_primary' => true
        ]);

        return response()->json([
            'status' => 'success',
            'id' => $homestay->id,
        ]);
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
        $this->setMeta('Edit Homestay');
        $facilities = Facility::all();
        return view('pages.backend.homestays.edit', compact('homestay', 'facilities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Homestay $homestay)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'is_available' => 'required',
            'facilities' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'capacity' => 'required|numeric',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], $this->message);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ]);
        }

        $homestay->update([
            'name' => $request->name,
            'is_available' => $request->is_available,
            'description' => $request->description,
            'price' => $request->price,
            'capacity' => $request->capacity,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        $homestay->facilities()->sync($request->facilities);

        if ($request->hasFile('image')) {
            // unlink old image
            $oldImage = public_path($homestay->images()->where('is_primary', true)->first()->image_path);
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }
            // delete old image
            $homestay->images()->where('is_primary', true)->delete();
            $imageName = time() . '.' . $request->image->extension();
            $size = $request->file('image')->getSize();
            $request->image->move(public_path('images/homestay'), $imageName);

            $homestay->images()->create([
                'name' => $imageName,
                'size' => $size,
                'image_path' => "images/homestay/" . $imageName,
                'is_primary' => true
            ]);
        }

        return response()->json([
            'status' => 'success',
            'id' => $homestay->id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Homestay $homestay)
    {
        // unlink all image
        foreach ($homestay->images as $image) {
            $oldImage = public_path($image->image_path);
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }
        }
        $homestay->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Homestay berhasil dihapus',
        ]);
    }

    public function getImages(Homestay $homestay)
    {
        // get homestay images
        $images = $homestay->images->where('is_primary', 0)->toArray();
        return response()->json($images);
    }

    public function storeImage(Request $request)
    {
        $homestay = Homestay::findOrFail($request->homestay_id);
        foreach ($request->file('file') as $image) {
            $size = $image->getSize();
            $imageName = (time() + rand(1, 100)) . '.' . $image->extension();
            $image->move(public_path('images/homestays'), $imageName);
            $homestay->images()->create([
                'name' => $imageName,
                'size' => $size,
                'image_path' => "images/homestays/" . $imageName,
                'is_primary' => false
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil ditambahkan',
        ]);
    }

    public function deleteImage(Request $request)
    {
        $image = Image::where('name', $request->name)->first();
        if ($image == null) {
            return;
        }
        // dd($image);
        $oldImage = public_path('images/homestays/' . $image->image_path);
        if (file_exists($oldImage)) {
            unlink($oldImage);
        }
        $image->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus',
        ]);
    }
}
