<?php

namespace App\Http\Controllers\Backend;

use App\Models\Image;
use App\Models\Facility;
use App\Models\Homestay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\NewRequestHomestayNotification;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image as ImageIntervention;

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
            $homestays = [];
            if (auth()->user()->hasRole('admin')) {
                $homestays = Homestay::with('facilities')->get();
            } else {
                $homestays = Homestay::where('owner_id', auth()->user()->id)->with('facilities')->get();
            }
            return DataTables::of($homestays)
                ->addColumn('checkbox', function ($data) {
                    return '<input type="checkbox" name="id[]" value="' . $data->id . '" onclick="check(this)" />';
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
            'total_rooms' => 'required|numeric',
            'price_per_night' => 'required|numeric',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'owner_phone_number' => 'required',
            'owner_name' => 'required',
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
            'total_rooms' => $request->total_rooms,
            'price_per_night' => $request->price_per_night,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'owner_phone_number' => $request->owner_phone_number,
            'owner_name' => $request->owner_name
        ]);

        $homestay->facilities()->attach($request->facilities);

        $imageName = (time() + rand(1, 100)) . '.' . $request->image->extension();
        // resize image
        $img = ImageIntervention::make($request->image->path());
        $img->resize(1450, 750, function ($constraint) {
            $constraint->aspectRatio();
        });
        // check path
        if (!file_exists(public_path('images/homestays'))) {
            mkdir(public_path('images/homestays'), 0777, true);
        }
        $img->save(public_path('images/homestays/' . $imageName));
        $size = $img->filesize();

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
            'total_rooms' => 'required|numeric',
            'price_per_night' => 'required|numeric',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'owner_phone_number' => 'required',
            'owner_name' => 'required',
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
            'total_rooms' => $request->total_rooms,
            'price_per_night' => $request->price_per_night,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'owner_phone_number' => $request->owner_phone_number,
            'owner_name' => $request->owner_name
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
            // resize image
            $img = ImageIntervention::make($request->image->path());
            $img->resize(1000, 667, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save(public_path('images/homestays/' . $imageName));
            $size = $img->filesize();
            // $size = $request->file('image')->getSize();
            // $request->image->move(public_path('images/homestay'), $imageName);

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
            // $size = $image->getSize();
            $imageName = (time() + rand(1, 100)) . '.' . $image->extension();
            // resize image
            $img = ImageIntervention::make($image->path());
            $img->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save(public_path('images/homestays/' . $imageName));
            $size = $img->filesize();
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

    public function delete_selected(Request $request)
    {
        $ids = $request->ids;
        Homestay::whereIn('id', $ids)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User yang dipilih berhasil dihapus',
        ]);
    }
}
