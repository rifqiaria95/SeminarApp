<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //  Function Index untuk menampilkan data user
    public function index(Request $request)
    {
        // Menampilkan Data user
        $user       = User::all();
        // dd($kelas);
        if ($request->ajax()) {
            return datatables()->of($user)
            ->addColumn('status_user', function(User $user) {
                $inactive = '<span class="badge bg-label-danger">Inactive</span>';
                $active   = '<span class="badge bg-label-success">Active</span>';
                if($user->status_user == 0) {
                    return $inactive;
                }  else if ($user->status_user == 1) {
                    return $active;
                }
            })
            ->addColumn('aksi', function ($data) {
                $button = '<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group me-2" role="group" aria-label="First group">
                    <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm edit-user"><i class="fa-solid fa-pen"></i></a>
                    <button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
                    <a href="user/profile/' . $data->id . '" name="view" class="view btn btn-secondary btn-sm"><i class="far fa-eye"></i></a>
                </div>
            </div>';
                return $button;
            })
            ->rawColumns(['status_user', 'aksi'])
            ->addIndexColumn()
            ->toJson();
        }

        return view('user.index', compact(['user']));
    }

    public function store(Request $request)
    {
        $messages  = [
            'required' => 'Kolom harus diisi.',
            'string'   => 'Kolom harus berupa teks.',
            'numeric'  => 'Kolom harus berupa angka.',
            'max'      => 'Kolom maksimal :max kata.',
            'mimes'    => 'Format file harus jpg/png.',
            'email'    => 'Format harus berupa email.',
            'unique'   => 'Email yang didaftarkan sudah ada!',
        ];
        
        $validator = Validator::make($request->all(), [
            'name'        => 'required|max:255',
            'password'    => 'required|min:8',
            'email'       => 'required|email|unique:users',
            'role'        => 'required',
            'status_user' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 400,
                'errors'    => $validator->messages()
            ]);
        } else {

            $name        = $request->name;
            $password    = Hash::make($request->password);
            $email       = $request->email;
            $role        = $request->role;
            $status_user = $request->status_user;

            // Buat objek Pembicara dan simpan data jika memenuhi syarat
            $user              = new User;
            $user->name        = $name;
            $user->password    = $password;
            $user->email       = $email;
            $user->role        = $role;
            $user->status_user = $status_user;
            $user->save();

            // Tambahkan aktivitas log
            // \ActivityLog::addToLog('Menambah data user');

            // Kirim respons berhasil
            return response()->json([
                'status' => 200,
                'message' => 'Data user berhasil ditambahkan. '
            ]);
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    public function update($id, Request $request)
    {
        $messages = [
            'required' => 'Kolom harus diisi.',
            'string'   => 'Kolom harus berupa teks.',
            'max'      => 'Kolom maksimal :max kata.',
            'mimes'    => 'Format file harus jpg/png.',
        ];
        
        $validator = Validator::make($request->all(), [
            'avatar' => 'mimes:jpg,png|max:2048', // Tambahkan batasan ukuran file
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 400,
                'errors'  => $validator->messages(),
            ]);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status'  => 404,
                'errors'  => 'User Tidak Ditemukan',
            ]);
        }

        // Perbarui semua data kecuali avatar
        $user->name        = $request->input('name');
        $user->email       = $request->input('email');
        $user->role        = $request->input('role');
        $user->status_user = $request->input('status_user');

        if ($request->hasFile('avatar')) {
            $this->updateUserAvatar($user, $request->file('avatar'));
        }

        $user->save();

        return response()->json([
            'status'  => 200,
            'message' => 'Data user berhasil diubah',
        ]);
    }

    private function updateUserAvatar($user, $avatarFile)
    {
        if ($user->avatar) {
            $oldAvatarPath = 'images/' . $user->avatar;
            if (File::exists($oldAvatarPath)) {
                File::delete($oldAvatarPath);
            }
        }

        $avatarName = time() . '_' . $avatarFile->getClientOriginalName();
        $avatarFile->move('images/', $avatarName);
        $user->avatar = $avatarName;
    }


    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $path = 'images/' . $user->avatar;
            if (File::exists($path)) {
                File::delete($path);
            }
            $user->delete();

            // \ActivityLog::addToLog('Menghapus data user');

            return response()->json([
                'status' => 200,
                'message' => 'Data User Berhasil Dihapus'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'errors' => 'Data User Tidak Ditemukan'
            ]);
        }
    }

    public function profile($id)
    {
        $user     = User::find($id);
        return view('user.profile', compact(['user']));
    }
}
