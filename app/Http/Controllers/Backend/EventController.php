<?php

namespace App\Http\Controllers\Backend;

use App\Models\Event;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class EventController extends Controller
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
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->setMeta('Events');
        if ($request->ajax()) {
            return DataTables::of(Event::query())
                ->addColumn('checkbox', function ($data) {
                    return '<input type="checkbox" name="id[]" value="' . $data->id . '">';
                })
                ->editColumn('start_date', function ($data) {
                    return $data->start_date->format('d M Y');
                })
                ->editColumn('end_date', function ($data) {
                    return $data->end_date->format('d M Y');
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group" role="group">
                            <a href="' . route('backend.events.edit', $data->id) . '" class="btn btn-warning">
                                <i class="fas fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="javascript:;" onclick="handle_confirm(\'Apakah Anda Yakin?\',\'Yakin\',\'Tidak\',\'DELETE\',\'' . route('backend.events.destroy', $data->id) . '\');" class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>';
                })
                ->rawColumns(['action', 'checkbox'])
                ->make(true);
        }
        return view('pages.backend.events.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.backend.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'         => 'required',
            'address'       => 'required',
            'description'   => 'required',
            'start_date'    => 'required|date|before:end_date',
            'end_date'      => 'required|date|after:start_date',
            'latitude'      => 'required',
            'longitude'     => 'required',
            'image'         => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ]);
        }

        $event = Event::create([
            'title'         => $request->title,
            'address'       => $request->address,
            'description'   => $request->description,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'latitude'      => $request->latitude,
            'longitude'     => $request->longitude,
        ]);

        $imageName = (time() + rand(1, 100)) . '.' . $request->image->extension();
        $size = $request->file('image')->getSize();
        $request->image->move(public_path('images/events'), $imageName);

        $event->images()->create([
            'name' => $imageName,
            'size' => $size,
            'image_path' => "images/events/" . $imageName,
            'is_primary' => true
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Event berhasil ditambahkan',
            'id' => $event->id,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('pages.backend.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validator = Validator::make($request->all(), [
            'title'         => 'required',
            'address'       => 'required',
            'description'   => 'required',
            'start_date'    => 'required|date|before:end_date',
            'end_date'      => 'required|date|after:start_date',
            'latitude'      => 'required',
            'longitude'     => 'required',
            'image'         => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ]);
        }

        $event->update([
            'title'         => $request->title,
            'address'       => $request->address,
            'description'   => $request->description,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'latitude'      => $request->latitude,
            'longitude'     => $request->longitude,
        ]);

        if ($request->hasFile('image')) {
            // unlink old image
            $oldImage = public_path($event->images()->where('is_primary', true)->first()->image_path);
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }

            // delete old image
            $event->images()->where('is_primary', true)->delete();

            // upload new image
            $imageName = (time() + rand(1, 100)) . '.' . $request->image->extension();
            $size = $request->file('image')->getSize();
            $request->image->move(public_path('images/events'), $imageName);

            $event->images()->create([
                'name' => $imageName,
                'size' => $size,
                'image_path' => "images/events/" . $imageName,
                'is_primary' => true
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil diubah',
            'id' => $event->id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //unlink image
        foreach ($event->images as $image) {
            unlink(public_path($image->image_path));
        }
        $event->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus',
        ]);
    }

    public function getImages(Event $event)
    {
        // get all images except primary image
        $images = $event->images->where('is_primary', 0)->toArray();
        return response()->json($images);
    }

    public function storeImage(Request $request)
    {
        $event = Event::findOrFail($request->event_id);
        foreach ($request->file('file') as $image) {
            $size = $image->getSize();
            $imageName = (time() + rand(1, 100)) . '.' . $image->extension();
            $image->move(public_path('images/events'), $imageName);
            $event->images()->create([
                'name' => $imageName,
                'size' => $size,
                'image_path' => "images/events/" . $imageName,
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
        $oldImage = public_path('images/events/' . $image->image_path);
        if (file_exists($oldImage)) {
            unlink($oldImage);
        }
        $image->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Gambar berhasil dihapus',
        ]);
    }
}
