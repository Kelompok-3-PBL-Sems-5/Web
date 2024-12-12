<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $id = session('id_user');

        $breadcrumb = (object) [
            'title' => 'Profile',
            'list' => ['Home', 'profile']
        ];

        $page = (object) [
            'title' => 'Profile Anda'
        ];

        $activeMenu = 'profile'; // set menu yang sedang aktif
    
        $user = UserModel::with('level')->find($id);

        $level = LevelModel::all(); // ambil data level untuk filter level
        return view('profile.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'user' => $user,'activeMenu' => $activeMenu]);
    }
    public function show(string $id)
    {
        $user = UserModel::with('level')->find($id);
        $breadcrumb = (object) ['title' => 'Detail User', 'list' => ['Home', 'User', 'Detail']];
        $page = (object) ['title' => 'Detail user'];
        $activeMenu = 'user'; // set menu yang sedang aktif
        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }
    public function edit_ajax(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('id_level', 'nama_level')->get();
        return view('profile.edit_ajax', ['user' => $user, 'level' => $level]);
    }
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // 'id_level' => 'nullable|integer',
                'nama_user' => 'nullable|max:100',
                'username' => 'nullable|max:20|unique:m_user,username,' . $id . ',id_user',
                'password' => 'nullable|min:6|max:20',
                'nidn_user' => 'nullable|integer',
                'gelar_akademik' => 'nullable|string',
                'email_user' => 'nullable|string',
            ];

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }
            
            $check = UserModel::find($id);
            if ($check) {
                // if (!$request->filled('id_level')) { // jika password tidak diisi, maka hapus dari request
                //     $request->request->remove('id_level');
                // }
                if (!$request->filled('username')) { // jika password tidak diisi, maka hapus dari request
                    $request->request->remove('username');
                }
                if (!$request->filled('nama_user')) { // jika password tidak diisi, maka hapus dari request
                    $request->request->remove('nama_user');
                }
                if (!$request->filled('password')) { // jika password tidak diisi, maka hapus dari request
                    $request->request->remove('password');
                }
                if (!$request->filled('nidn_user')) {
                    $request->request->remove('nidn_user');
                }
                if (!$request->filled('gelar_akademik')) {
                    $request->request->remove('gelar-akademik');
                }
                if (!$request->filled('email_user')) {
                    $request->request->remove('email_user');
                }
                $check->update([
                    // 'id_level'  => $request->id_level,
                    'nama_user'      => $request->nama_user,
                    'username'  => $request->username,
                    'password'  => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
                    'nidn_user' => $request->nidn_user,
                    'gelar_akademin' => $request->gelar_akademik,
                    'email_user' => $request->email_user,
                ]);
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
    public function edit_foto(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('id_level', 'nama_level')->get();
        return view('profile.edit_foto', ['user' => $user, 'level'=>$level]);
    }
    public function update_foto(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'foto'   => 'required|mimes:jpeg,png,jpg|max:4096'
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }
            $check = UserModel::find($id);
            if ($check) {
                if ($request->has('foto')) {
                    $file = $request->file('foto');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $path = 'images/profile/';
                    $file->move($path, $filename);
                }
                $check->update([
                    'foto'      => $path.$filename
                ]);
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
}
