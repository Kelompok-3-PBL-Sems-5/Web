<?php
namespace App\Http\Controllers;
use App\Models\BidangMinatModel;
use App\Models\DabimModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;

class BidangMinatController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Bidang Minat',
            'list' => ['Home', 'Bidang Minat']
        ];
        $page = (object) [
            'title' => 'Daftar bidang minat yang terdaftar dalam sistem'
        ];
        $activeMenu = 'bidang_minat'; // set menu yang sedang aktif
        $user = UserModel::all(); // ambil data supplier untuk filter user
        $dabim = DabimModel::all(); // ambil data supplier untuk filter user
        return view('bidang_minat.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu,'dabim' => $dabim ]);
    }
    
    // Ambil data bidang minat dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $bidang_minat = BidangMinatModel::select('id_bidang_minat', 'id_user', 'id_dabim')
            ->with('user')
            ->with('dabim');

        // filter
        if ($request->id_user) {
            $bidang_minat->where('id_user', $request->id_user);
        }
        if ($request->id_dabim) {
            $bidang_minat->where('id_dabim', $request->id_dabim);
        }
        
        return DataTables::of($bidang_minat)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($bidang_minat) { // menambahkan kolom aksi
                $btn = '<button onclick="modalAction(\'' . url('/bidang_minat/' . $bidang_minat->id_bidang_minat) . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/bidang_minat/' . $bidang_minat->id_bidang_minat . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/bidang_minat/' . $bidang_minat->id_bidang_minat . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    // Menampilkan detail bidang minat
    public function show(string $id)
    {
        $bidang_minat = BidangMinatModel::with('user')->find($id);
        $bidang_minat = BidangMinatModel::with('dabim')->find($id);
        $breadcrumb = (object) ['title' => 'Detail Bidang Minat', 'list' => ['Home', 'Bidang Minat', 'Detail']];
        $page = (object) ['title' => 'Detail Bidang Minat'];
        $activeMenu = 'bidang_minat'; // set menu yang sedang aktif
        return view('bidang_minat.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'bidang_minat' => $bidang_minat, 'activeMenu' => $activeMenu]);
    }

    // 1. public function create_ajax()
    public function create_ajax()
    {
        $user = UserModel::select('id_user', 'nama_user')->get();
        $dabim = DabimModel::select('id_dabim', 'nama_dabim')->get();
        return view('bidang_minat.create_ajax')
            ->with('user', $user)
            ->with('dabim', $dabim);
    }
    

    // 2. public function store_ajax(Request $request)
    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_user'       => 'required|integer',
                'id_dabim'       => 'required|integer' 
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
            BidangMinatModel::create($request->all());
            return response()->json([
                'status'    => true,
                'message'   => 'Data user berhasil disimpan'
            ]);
        }
        redirect('/');
    }


    // 3. public function edit_ajax(string $id)
    public function edit_ajax(string $id)
    {
        $bidang_minat = BidangMinatModel::find($id);
        $user = UserModel::select('id_user', 'nama_user')->get();
        $dabim = dabimModel::select('id_dabim', 'nama_dabim')->get();

        return view('bidang_minat.edit_ajax', ['bidang_minat' => $bidang_minat, 'user' => $user, 'dabim' => $dabim]);
    }

    // 4. public function update_ajax(Request $request, $id)
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_user'       => 'required|integer',
                'id_dabim'       => 'required|integer'
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
            $check = BidangMinatModel::find($id);
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
        $bidang_minat = BidangMinatModel::find($id);
        return view('bidang_minat.confirm_ajax', ['bidang_minat' => $bidang_minat]);
    }

    // 6. public function delete_ajax(Request $request, $id)
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $bidang_minat = BidangMinatModel::find($id);
            if ($bidang_minat) {
                $bidang_minat->delete();
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
