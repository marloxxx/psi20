<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
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
    public function index()
    {
        $this->setMeta('Profile');
        $user = User::findOrFail(auth()->user()->id)->load('bookings.homestay', 'wishlists');
        // dd($user->wishlists->first()->name);
        return view('pages.frontend.profile.index', compact('user'));
    }

    public function update_password(Request $request)
    {
        $validator = validator($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:*',
            'confirm_password' => 'required|same:new_password'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ]);
        }
    }

    public function update_profile(Request $request)
    {
        $validator = validator($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
            'date_of_birth' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ]);
        }

        $user = User::findOrFail(auth()->user()->id);
        $user->update($request->all());
        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully.',
        ]);
    }

    public function upload_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ]);
        }

        $user = User::findOrFail(auth()->user()->id);
        $file = $request->file('file');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/profile'), $filename);
        $user->update([
            'profile_picture' => $filename
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully.',
        ]);
    }
}
