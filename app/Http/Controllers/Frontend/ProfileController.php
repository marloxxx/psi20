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
        $user = User::findOrFail(auth()->user()->id)->load('wishlists');
        $bookings = $user->bookings()->with('homestay')->latest('created_at')->get();
        return view('pages.frontend.profile.index', compact('user'));
    }

    public function update_password(Request $request)
    {
        $validator = validator($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:*',
            'confirm_password' => 'required|same:new_password'
        ], [
            'old_password.required' => 'Password lama tidak boleh kosong',
            'new_password.required' => 'Password baru tidak boleh kosong',
            'new_password.min' => 'Password baru minimal 8 karakter',
            'confirm_password.required' => 'Konfirmasi password tidak boleh kosong',
            'confirm_password.same' => 'Konfirmasi password tidak sama dengan password baru',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ]);
        }

        $user = User::findOrFail(auth()->user()->id);
        if (password_verify($request->old_password, $user->password)) {
            $user->update([
                'password' => bcrypt($request->new_password)
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Password berhasil diubah.',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Password lama salah.',
            ]);
        }
    }

    public function update_profile(Request $request)
    {
        $validator = validator($request->all(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'phone_number' => 'required|numeric|digits_between:10,13|unique:users,phone_number,' . auth()->user()->id . ',id|starts_with:08',
            'date_of_birth' => 'required|date_format:Y-m-d'
        ], [
            'first_name.required' => 'Nama depan tidak boleh kosong',
            'last_name.required' => 'Nama belakang tidak boleh kosong',
            'phone_number.required' => 'Nomor telepon tidak boleh kosong',
            'date_of_birth.required' => 'Tanggal lahir tidak boleh kosong',
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
            'message' => 'Profil berhasil diubah.',
        ]);
    }

    public function upload_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'file.required' => 'File tidak boleh kosong',
            'file.image' => 'File harus berupa gambar',
            'file.mimes' => 'File harus berupa gambar',
            'file.max' => 'File maksimal 2MB',
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
            'message' => 'Foto profil berhasil diubah.',
        ]);
    }
}
