<?php
namespace App\Http\Controllers;

use App\Models\ProdiModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\IOFactory;

class prodiController extends Controller
{
    // Menampilkan halaman awal prodi
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Prodi',
            'list'  => ['Home', 'Prodi']
        ];

        $page = (object) [
            'title' => 'Daftar prodi yang terdaftar dalam sistem'
        ];

        $activeMenu = 'prodi'; // set menu yang sedang aktif
        $prodi = ProdiModel::all();
        $user = UserModel::all();
        return view('prodi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'user' => $user, 'prodi' => $prodi]);
    }

    // Ambil data prodi dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        // Ambil data prodi
        $prodi = ProdiModel::select('id_prodi', 'id_user','kode_prodi', 'nama_prodi', 'jenjang')
        ->with('user');

        if ($request->id_user) {
            $prodi->where('id_user', $request->id_user);
        }

        // Return data untuk DataTables
        return DataTables::of($prodi)
            ->addIndexColumn() // menambahkan kolom index / nomor urut
            ->addColumn('aksi', function ($prodi) {
                $btn = '<button onclick="modalAction(\'' . url('/prodi/' . $prodi->id_prodi ) . '\')" class="btn btn-info btn-sm">Detail</a>';
                $btn .= '<button onclick="modalAction(\'' . url('/prodi/' . $prodi->id_prodi . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/prodi/' . $prodi->id_prodi . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi berisi HTML
            ->make(true);
    }

    // Menampilkan halaman form tambah prodi
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Prodi',
            'list'  => ['Home', 'Prodi', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Prodi Baru'
        ];

        $user = UserModel::all();
        $activeMenu = 'prodi'; // set menu yang sedang aktif

        return view('prodi.create', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'activeMenu' => $activeMenu,
            'user' => $user
        ]);
    }

    // Menampilkan detail prodi
    public function show(string $id)
    {
        $prodi = prodiModel::with('user')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Prodi',
            'list'  => ['Home', 'Prodi', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Prodi'
        ];

        $activeMenu = 'prodi'; // set menu yang sedang aktif

        return view('prodi.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'prodi' => $prodi, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit prodi
    public function edit(string $id)
    {
        $prodi = prodiModel::find($id);
        $user = UserModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Prodi',
            'list'  => ['Home', 'Prodi', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Prodi'
        ];

        $activeMenu = 'prodi'; // set menu yang sedang aktif

        return view('prodi.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'prodi' => $prodi, 'activeMenu' => $activeMenu, 'user' => $user]);
    }

    // Menghapus data prodi
    public function destroy(string $id)
    {
        $check = prodiModel::find($id);
        if (!$check) {  
            return redirect('/prodi')->with('error', 'Data prodi tidak ditemukan');
        }

        try {
            ProdiModel::destroy($id); 

            return redirect('/prodi')->with('success', 'Data prodi berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/prodi')->with('error', 'Data prodi gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    // 1. public function create_ajax()
    public function create_ajax()
    {
        $user = UserModel::select('id_user', 'nama_user')->get();
        return view('prodi.create_ajax')
        ->with('user', $user);
    }

    // 2. public function store_ajax(Request $request)
    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_user'    => 'required|integer',
                'kode_prodi' => 'required|string|max:100',
                'nama_prodi' => 'required|string|max:50',
                'jenjang'    => 'required|string|max:50',

                // 'nidn_user' => 'required|string|max:20',
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
            prodiModel::create([
                'id_user'        => $request->id_user,
                'kode_prodi'     => $request->kode_prodi,
                'nama_prodi'     => $request->nama_prodi,
                'jenjang'        => $request->jenjang
            ]);
            return response()->json([
                'status'    => true,
                'message'   => 'Data prodi berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    // 3. public function edit_ajax(string $id)
    public function edit_ajax(string $id)
    {
        $prodi = prodiModel::find($id);
        $user = UserModel::select('id_user', 'nama_user')->get();

        return view('prodi.edit_ajax', ['prodi' => $prodi, 'user' => $user]);
    }

    // 4. public function update_ajax(Request $request, $id)
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_user'    => 'required|integer',
                'kode_prodi' => 'required|string|max:100',
                'nama_prodi' => 'required|string|max:50',
                'jenjang'    => 'required|string|max:50',
                // 'nidn_user' => 'required|string|max:20',

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
            $check = prodiModel::find($id);
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
        $prodi = prodiModel::find($id);
        return view('prodi.confirm_ajax', ['prodi' => $prodi]);
    }

    // 6. public function delete_ajax(Request $request, $id)
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $prodi = prodiModel::find($id);
            if ($prodi) {
                $prodi->delete();
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

    public function show_ajax(string $id)
    {
        $prodi = ProdiModel::find($id);
        $user = UserModel::find($prodi->id_user);

        return view('prodi.show_ajax', ['prodi' => $prodi, 'user' => $user]);
    }

    //Pertemuan 8
    public function import()
    {
        return view('prodi.import');
    }
    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_prodi' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $file = $request->file('file_prodi'); // ambil file dari request
            $reader = IOFactory::createReader('Xlsx'); // load reader file excel
            $reader->setReadDataOnly(true); // hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); // load file excel
            $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
            $data = $sheet->toArray(null, false, true, true); // ambil data excel
            $insert = [];
            if (count($data) > 1) { // jika data lebih dari 1 baris
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { // baris ke 1 adalah header, maka lewati
                        $insert[] = [
                            'id_user'                  => $value['A'],
                            'kode_prodi'               => $value['B'],
                            'nama_prodi'               => $value['C'],
                            'jenjang'                  => $value['D'],
                            'created_at' => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    ProdiModel::insertOrIgnore($insert);
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }
        return redirect('/');
    }
    public function export_excel()
    {
        // ambil data barang yang akan di export
        $prodi = ProdiModel::select('id_user','kode_prodi', 'nama_prodi', 'jenjang')
            ->orderBy('id_user')
            ->with('user')
            ->get();
        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama User');
        $sheet->setCellValue('C1', 'Kode Prodi');
        $sheet->setCellValue('D1', 'Nama Prodi');
        $sheet->setCellValue('E1', 'Jenjang');

        $sheet->getStyle('A1:E1')->getFont()->setBold(true); // bold header
        $no = 1; // nomor data dimulai dari 1
        $baris = 2; // baris data dimulai dari baris ke 2
        foreach ($prodi as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->user->nama_user);
            $sheet->setCellValue('C' . $baris, $value->kode_prodi);
            $sheet->setCellValue('D' . $baris, $value->nama_prodi);
            $sheet->setCellValue('E' . $baris, $value->jenjang);
            $baris++;
            $no++;
        }
        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }
        $sheet->setTitle('Data Prodi'); // set title sheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Prodi ' . date('Y-m-d H:i:s') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified:' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer->save('php://output');
        exit;
    } // end function export_excel
    public function export_pdf()
    {
        $prodi = ProdiModel::select('id_user', 'kode_prodi', 'nama_prodi', 'jenjang')
            ->orderBy('id_user')
            ->with('user')
            ->get();
        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('prodi.export_pdf', ['prodi' => $prodi]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url $pdf->render();
        return $pdf->stream('Data prodi' . date('Y-m-d H:i:s') . '.pdf');
    }
}