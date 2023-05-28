<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    private $message;
    public function __construct()
    {
        SEOMeta::setTitleDefault(getSettings('site_name'));
        parent::__construct();
        $this->message = [
            'first_name.required' => 'Nama depan tidak boleh kosong',
            'last_name.required' => 'Nama belakang tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email harus berupa email',
            'email.unique' => 'Email sudah digunakan',
            'phone_number.required' => 'Nomor telepon tidak boleh kosong',
            'phone_number.numeric' => 'Nomor telepon harus berupa angka',
            'phone_number.digits_between' => 'Nomor telepon harus berupa angka dan minimal 10 digit',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 8 karakter',
            'roles.required' => 'Role tidak boleh kosong',
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
        $this->setMeta('Users');
        if ($request->ajax()) {
            return DataTables::of(User::query())
                ->addColumn('checkbox', function ($data) {
                    return '<input type="checkbox" name="id[]" value="' . $data->id . '">';
                })
                ->addColumn('roles', function ($data) {
                    return $data->getRoleNames()->implode(', ');
                })
                ->addColumn('action', function ($data) {
                    if ($data->id != 1) {
                        return '<div class="btn-group" role="group">
                        <a href="' . route('backend.users.edit', $data->id) . '" class="btn btn-warning">
                            <i class="fas fa-solid fa-pen-to-square"></i>
                        </a>
                        <a href="javascript:;" onclick="handle_confirm(\'Apakah Anda Yakin?\',\'Yakin\',\'Tidak\',\'DELETE\',\'' . route('backend.users.destroy', $data->id) . '\');" class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>';
                    }
                })
                ->rawColumns(['checkbox', 'action'])
                ->make(true);
        }
        return view('pages.backend.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('pages.backend.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|numeric|digits_between:10,15',
            'password' => 'required|min:8',
            'roles' => 'required'
        ], $this->message);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ]);
        }

        $user = User::create($request->except('roles', 'password') + [
            'password' => bcrypt($request->password)
        ]);

        $user->assignRole($request->roles);

        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil ditambahkan',
            'redirect' => route('backend.users.index')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();

        return view('pages.backend.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'phone_number' => 'required|numeric|digits_between:10,15',
            'password' => 'nullable|min:8',
            'roles' => 'required'
        ], $this->message);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ]);
        }

        $user->update($request->except('roles', 'password') + [
            'password' => bcrypt($request->password)
        ]);

        $user->syncRoles($request->roles);

        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil diupdate',
            'redirect' => route('backend.users.index')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id == 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'User tidak dapat dihapus',
            ]);
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil dihapus',
        ]);
    }

    public function delete_selected(Request $request)
    {
        $ids = $request->ids;
        User::whereIn('id', $ids)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User yang dipilih berhasil dihapus',
        ]);
    }
}
