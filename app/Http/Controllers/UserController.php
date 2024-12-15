<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\DataTables;


class UserController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];
        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];
        $activeMenu = 'user'; // set menu yang sedang aktif

        $level = LevelModel::all(); // ambil data level untuk filter level
        return view('dosen.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    // Ambil data user dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $user = UserModel::all()
            ->with('level');

        // filter data user berdasarkan level_id
        if ($request->level_id) {
            $user->where('id_level', $request->id_level);
        }

        // return DataTables::of($users)
        //     // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
        //     ->addIndexColumn()
        //     ->addColumn('aksi', function ($user) { // menambahkan kolom aksi
        //         $btn = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a> ';
        //         $btn .= '<a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
        //         $btn .= '<form class="d-inline-block" method="POST" action="' .
        //             url('/user/' . $user->user_id) . '">'
        //             . csrf_field() . method_field('DELETE') .
        //             '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm
        //             (\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
        //         return $btn;
        //     })
        //     ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
        //     ->make(true);
        // $user = UserModel::select('user_id', 'username', 'nama', 'foto', 'level_id')
        //     ->with('level');

        // $level_id = $request->input('filter_level');
        // if (!empty($level_id)) {
        //     $user->where('level_id', $level_id);
        // }

        // // Filter data user berdasarkan level_id
        // if ($request->level_id) {
        //     $user->where('level_id', $request->level_id);
        // }
        return DataTables::of($user)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addColumn('aksi', function ($user) { // menambahkan kolom aksi 
                $btn = '<a href="' . url('/user/' . $user->id_user) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->id_user . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->id_user . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true);
    }

    // Menampilkan halaman form tambah user 
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah user baru'
        ];

        $level = LevelModel::all(); // ambil data level untuk ditampilkan di form
        $activeMenu = 'user'; // set menu yang sedang aktif
        return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function create_ajax()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('dosen.create_ajax')
            ->with('level', $level);
    }

    // Menyimpan data user baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'username_user' => 'required|string|min:3|unique:m_user,username_user',
            'nama_user' => 'required|string|max:100',
            'password_user' => 'required|min:5',
            'email_user' => 'nullable|email|max:100',
            'nidn_user' => 'nullable|string|max:20',
            'gelar_akademik' => 'nullable|string|max:50',
            'id_level' => 'required|integer|exists:m_level,id_level',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:4096' // Maksimum 4 MB
        ]);
    
        // Menghandle upload foto jika ada
        $path = null; // Default null jika tidak ada upload foto
        $filename = null;
    
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = 'images/profiles/'; // Path penyimpanan
            $file->move(public_path($path), $filename); // Simpan file ke direktori public
        }
    
        // Membuat data user baru
        UserModel::create([
            'id_level' => $request->id_level,
            'username_user' => $request->username_user,
            'nama_user' => $request->nama_user,
            'password_user' => bcrypt($request->password_user), // Enkripsi password
            'nidn_user' => $request->nidn_user,
            'gelar_akademik' => $request->gelar_akademik,
            'email_user' => $request->email_user,
            'foto' => $path ? $path . $filename : null // Simpan path foto jika ada
        ]);
    
        // Redirect dengan pesan sukses
        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }
    

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'username_user' => 'required|string|min:3|unique:m_user,username_user',
                'nama_user' => 'required|string|max:100',
                'password_user' => 'required|min:5',
                'email_user' => 'nullable|email|max:100',
                'nidn_user' => 'nullable|string|max:20',
                'gelar_akademik' => 'nullable|string|max:50',
                'id_level' => 'required|integer|exists:m_level,id_level',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:4096' // Maksimum 4 MB
                ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'    => false, // response status, false: error/gagal, true: berhasil
                    'message'   => 'Validasi Gagal',
                    'msgField'  => $validator->errors(), // pesan error validasi
                ]);
            }
            if ($request->has('foto')) {
                $file = $request->file('foto');
                $extension = $file->getClientOriginalExtension();

                $filename = time() . '.' . $extension;

                $path = 'image/profile/';
                $file->move($path, $filename);
            }
            UserModel::create([
                'id_level' => $request->id_level,
                'username_user' => $request->username_user,
                'nama_user' => $request->nama_user,
                'password_user' => bcrypt($request->password_user), // Enkripsi password
                'nidn_user' => $request->nidn_user,
                'gelar_akademik' => $request->gelar_akademik,
                'email_user' => $request->email_user,
                'foto' => $path ? $path . $filename : null // Simpan path foto jika ada
                ]);
            return response()->json([
                'status'    => true,
                'message'   => 'Data user berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    // Menampilkan detail user
    public function show(string $id)
    {
        $user = UserModel::with('level')->find($id);
        $breadcrumb = (object) ['title' => 'Detail User', 'list' => ['Home', 'User', 'Detail']];
        $page = (object) ['title' => 'Detail user'];
        $activeMenu = 'user'; // set menu yang sedang aktif
        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman fore edit user 
    public function edit(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit']
        ];

        $page = (object) [
            "title" => 'Edit user'
        ];

        $activeMenu = 'user'; // set menu yang sedang aktif
        return view('user.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit user ajax
    public function edit_ajax(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('id_level', 'nama_level')->get();
        return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
    }

    // Menyimpan perubahan data user
    public function update(Request $request, string $id)
    {
        $request->validate([
            'username_user' => 'required|string|min:3|unique:m_user,username_user',
            'nama_user' => 'required|string|max:100',
            'password_user' => 'required|min:5',
            'email_user' => 'nullable|email|max:100',
            'nidn_user' => 'nullable|string|max:20',
            'gelar_akademik' => 'nullable|string|max:50',
            'id_level' => 'required|integer|exists:m_level,id_level',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:4096' // Maksimum 4 MB
    ]);
        UserModel::find($id)->update([
            'username'  => $request->username,
            'nama'      => $request->nama,
            'password'  => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
            'level_id'  => $request->level_id
        ]);
        return redirect('/user')->with("success", "Data user berhasil diubah");
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
                'nama' => 'required|max:100',
                'password' => 'nullable|min:6|max:20',
                'foto'      => 'nullable|mimes:jpeg,png,jpg|max:4096'
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
                if (!$request->filled('password')) { // jika password tidak diisi, maka hapus dari request
                    $request->request->remove('password');
                }
                if (!$request->filled('foto')) { // jika password tidak diisi, maka hapus dari request 
                    $request->request->remove('foto');
                }
                if (isset($check->foto)) {
                    $fileold = $check->foto;
                    if (Storage::disk('public')->exists($fileold)) {
                        Storage::disk('public')->delete($fileold);
                    }
                    if ($request->has('foto')) {
                        $file = $request->file('foto');
                        $filename = $check->foto;
                        $path = 'image/profile/';
                        $file->move($path, $filename);
                        $pathname = $filename;
                        $request['foto'] = $pathname;
                    }
                } else {
                    if ($request->has('foto')) {
                        $file = $request->file('foto');
                        $extension = $file->getClientOriginalExtension();

                        $filename = time() . '.' . $extension;

                        $path = 'image/profile/';
                        $file->move($path, $filename);
                        $pathname = $path . $filename;
                        $request['foto'] = $pathname;
                    }
                }
                $check->update($request->all());

                // $check->update([
                //     'username'  => $request->username,
                //     'nama'      => $request->nama,
                //     'password'  => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
                //     'level_id'  => $request->level_id
                // ]);
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

    public function confirm_ajax(string $id)
    {
        $user = UserModel::find($id);
        return view('user.confirm_ajax', ['user' => $user]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserModel::find($id);
            if ($user) {
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
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

    // Menghapus data user
    public function destroy(string $id)
    {
        $check = UserModel::find($id);
        if (!$check) {      // untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try {
            UserModel::destroy($id); // Hapus data level
            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error

            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function import()
    {
        return view('user.import');
    }
}
