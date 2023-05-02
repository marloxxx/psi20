<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Homestay;
use Illuminate\Http\Request;

class HomestayController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.frontend.homestay.index');
    }

    public function show(Homestay $homestay)
    {
        return view('pages.frontend.homestay.show', compact('homestay'));
    }
}
