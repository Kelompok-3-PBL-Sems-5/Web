<?php
namespace App\Http\Controllers;

use App\Models\DamatModel;
use App\Models\MatKulModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;

class MatKulController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Mata Kuliah',
            'list' => ['Home', 'Mata Kuliah']
        ];
        $page = (object) [
            'title' => 'Daftar Mata Kuliah yang terdaftar dalam sistem'
        ];
        $activeMenu = 'matkul'; // set menu yang sedang aktif
        $user = UserModel::all(); // ambil data  untuk filter user(
        $damat = DamatModel::all();
        return view('matkul.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu, 'damat' => $damat]);
    }
    
    // Ambil data Mata Kuliah dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $matkul = MatKulModel::select('id_matkul', 'id_user', 'id_damat')
            ->with('user')
            ->with('damat');

        // filter
        if ($request->id_user) {
            $matkul->where('id_user', $request->id_user);
        }
        if ($request->id_damat) {
            $matkul->where('id_damat', $request->id_damat);
        }
        
        return DataTables::of($matkul)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($matkul) { // menambahkan kolom aksi
                $btn = '<button onclick="modalAction(\'' . url('/matkul/' . $matkul->id_matkul) . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/matkul/' . $matkul->id_matkul . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/matkul/' . $matkul->id_matkul . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    // Menampilkan detail Mata Kuliah
    public function show(string $id)
    {
        $matkul = MatKulModel::with('user')->find($id);
        $damat = DamatModel::with('damat')->find($id);
        $breadcrumb = (object) ['title' => 'Detail Mata Kuliah', 'list' => ['Home', 'Mata Kuliah', 'Detail']];
        $page = (object) ['title' => 'Detail Mata Kuliah'];
        $activeMenu = 'matkul'; // set menu yang sedang aktif
        return view('matkul.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'matkul' => $matkul, 'activeMenu' => $activeMenu, 'damat' => $damat]);
    }
    
    // 1. public function create_ajax()
    public function create_ajax()
    {
        $user = UserModel::select('id_user', 'nama_user')->get();
        $damat = DamatModel::select('id_damat', 'nama_damat')->get();
        return view('matkul.create_ajax')
            ->with('user', $user)
            ->with('damat', $damat);
    }
    

    // 2. public function store_ajax(Request $request)
    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_user'       => 'required|integer',
                'id_damat'       => 'required|integer'
                 
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
            MatKulModel::create($request->all());
            return response()->json([
                'status'    => true,
                'message'   => 'Data mata kuliah berhasil disimpan'
            ]);
        }
        redirect('/');
    }


    // 3. public function edit_ajax(string $id)
    public function edit_ajax(string $id)
    {
        $matkul = MatKulModel::find($id);
        $user = UserModel::select('id_user', 'nama_user')->get();
        $damat = DamatModel::select('id_damat', 'nama_damat')->get();

        return view('matkul.edit_ajax', ['matkul' => $matkul, 'user' => $user, 'damat' => $damat]);
    }

    // 4. public function update_ajax(Request $request, $id)
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_user'       => 'required|integer',
                'id_damat'      => 'required|integer'
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
            $check = MatKulModel::find($id);
            if ($check) {
                $check->update($request->all());
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

    // 5. public function confirm_ajax(string $id)
    public function confirm_ajax(string $id)
    {
        $matkul = MatKulModel::find($id);
        return view('matkul.confirm_ajax', ['matkul' => $matkul]);
    }

    // 6. public function delete_ajax(Request $request, $id)
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $matkul = MatKulModel::find($id);
            if ($matkul) {
                $matkul->delete();
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
}