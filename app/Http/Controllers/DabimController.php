<?php
namespace App\Http\Controllers;

use App\Models\DabimModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DabimController extends Controller
{
    // Menampilkan halaman awal Data Bidang Minat
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Data Bidang Minat',
            'list'  => ['Home', 'Data Bidang Minat']
        ];

        $page = (object) [
            'title' => 'Daftar Data Bidang Minat yang terdaftar dalam sistem'
        ];

        $activeMenu = 'dabim'; // set menu yang sedang aktif

        return view('dabim.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Ambil data Data Bidang Minat dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $dabim = DabimModel::select('id_dabim', 'nama_dabim');

        // Return data untuk DataTables
        return DataTables::of($dabim)
            ->addIndexColumn() // menambahkan kolom index / nomor urut
            ->addColumn('aksi', function ($dabim) {
           
                $btn = '<button onclick="modalAction(\'' . url('/dabim/' . $dabim->id_dabim ) . '\')" class="btn btn-info btn-sm">Detail</a>';
                $btn .= '<button onclick="modalAction(\'' . url('/dabim/' . $dabim->id_dabim . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/dabim/' . $dabim->id_dabim . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi berisi HTML
            ->make(true);
    }

    // Menampilkan detail Data Bidang Minat
    public function show(string $id)
    {
        $dabim = DabimModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Data Bidang Minat',
            'list'  => ['Home', 'Data Bidang Minat', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Data Bidang Minat'
        ];

        $activeMenu = 'dabim'; // set menu yang sedang aktif

        return view('dabim.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'dabim' => $dabim, 'activeMenu' => $activeMenu]);
    }

    // 1. public function create_ajax()
    public function create_ajax()
    {
        return view('dabim.create_ajax');
    }

    // 2. public function store_ajax(Request $request)
    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_dabim' => 'required|string|max:100'
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
            DabimModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data Data Bidang Minat berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    // 3. public function edit_ajax(string $id)
    public function edit_ajax(string $id)
    {
        $dabim = DabimModel::find($id);
        return view('dabim.edit_ajax', ['dabim' => $dabim]);
    }

    // 4. public function update_ajax(Request $request, $id)
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_dabim' => 'required|max:100'
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
            $check = DabimModel::find($id);
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
        $dabim = DabimModel::find($id);
        return view('dabim.confirm_ajax', ['dabim' => $dabim]);
    }

    // 6. public function delete_ajax(Request $request, $id)
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $dabim = DabimModel::find($id);
            if ($dabim) {
                $dabim->delete();
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