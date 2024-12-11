<?php
namespace App\Http\Controllers;

use App\Models\DamatModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DamatController extends Controller
{
    // Menampilkan halaman awal Data Mata Kuliah
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Data Mata Kuliah',
            'list'  => ['Home', 'Data Mata Kuliah']
        ];

        $page = (object) [
            'title' => 'Daftar Data Mata Kuliah yang terdaftar dalam sistem'
        ];

        $activeMenu = 'damat'; // set menu yang sedang aktif

        return view('damat.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Ambil data Data Mata Kuliah dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $damat = DamatModel::select('id_damat', 'nama_damat', 'kode_damat');

        // Return data untuk DataTables
        return DataTables::of($damat)
            ->addIndexColumn() // menambahkan kolom index / nomor urut
            ->addColumn('aksi', function ($damat) {
           
                $btn = '<button onclick="modalAction(\'' . url('/damat/' . $damat->id_damat ) . '\')" class="btn btn-info btn-sm">Detail</a>';
                $btn .= '<button onclick="modalAction(\'' . url('/damat/' . $damat->id_damat . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/damat/' . $damat->id_damat . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi berisi HTML
            ->make(true);
    }

    // Menampilkan detail Data Mata Kuliah
    public function show(string $id)
    {
        $damat = DamatModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Data Mata Kuliah',
            'list'  => ['Home', 'Data Mata Kuliah', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Data Mata Kuliah'
        ];

        $activeMenu = 'damat'; // set menu yang sedang aktif

        return view('damat.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'damat' => $damat, 'activeMenu' => $activeMenu]);
    }

    // 1. public function create_ajax()
    public function create_ajax()
    {
        return view('damat.create_ajax');
    }

    // 2. public function store_ajax(Request $request)
    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_damat' => 'required|string|max:100',
                'kode_damat' => 'required|string|max:100'
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors() // pesan error validasi
                ]);
            }
            DamatModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data Data Mata Kuliah berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    // 3. public function edit_ajax(string $id)
    public function edit_ajax(string $id)
    {
        $damat = DamatModel::find($id);
        return view('damat.edit_ajax', ['damat' => $damat]);
    }

    // 4. public function update_ajax(Request $request, $id)
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_damat' => 'required|max:100',
                'kode_damat' => 'required|max:100'
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
            $check = DamatModel::find($id);
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
        $damat = DamatModel::find($id);
        return view('damat.confirm_ajax', ['damat' => $damat]);
    }

    // 6. public function delete_ajax(Request $request, $id)
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $damat = DamatModel::find($id);
            if ($damat) {
                $damat->delete();
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