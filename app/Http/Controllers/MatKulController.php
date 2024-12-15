<?php
namespace App\Http\Controllers;
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
        $user = UserModel::all(); // ambil data  untuk filter user
        return view('matkul.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }
    
    // Ambil data Mata Kuliah dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $matkul = MatKulModel::select('id_matkul', 'id_user', 'kode_matkul', 'nama_matkul')
            ->with('user');

        // filter
        if ($request->id_user) {
            $matkul->where('id_user', $request->id_user);
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

    // Menampilkan halaman form tambah Mata Kuliah 
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Mata Kuliah',
            'list' => ['Home', 'Mata Kuliah', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah Mata Kuliah baru'
        ];
        $user = UserModel::all(); // ambil data  untuk filter 
        $activeMenu = 'matkul'; // set menu yang sedang aktif
        return view('matkul.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan detail Mata Kuliah
    public function show(string $id)
    {
        $matkul = MatKulModel::with('user')->find($id);
        $breadcrumb = (object) ['title' => 'Detail Mata Kuliah', 'list' => ['Home', 'Mata Kuliah', 'Detail']];
        $page = (object) ['title' => 'Detail Mata Kuliah'];
        $activeMenu = 'matkul'; // set menu yang sedang aktif
        return view('matkul.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'matkul' => $matkul, 'activeMenu' => $activeMenu]);
    }
    // Menampilkan halaman fore edit Mata Kuliah 
    public function edit(string $id)
    {
        $matkul = MatKulModel::find($id);
        $user = UserModel::all(); // ambil data user untuk filter user
        $breadcrumb = (object) [
            'title' => 'Edit Mata Kuliah',
            'list' => ['Home', 'Mata Kuliah', 'Edit']
        ];
        $page = (object) [
            "title" => 'Edit Mata Kuliah'
        ];
        $activeMenu = 'matkul'; // set menu yang sedang aktif
        return view('matkul.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'matkul'=> $matkul, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    // Menghapus data Mata Kuliah 
    public function destroy(string $id)
    {
        $check = MatKulModel::find($id);
        if (!$check) {      // untuk mengecek apakah data Mata Kuliah dengan id yang dimaksud ada atau tidak
            return redirect('/matkul')->with('error', 'Data Mata Kuliah tidak ditemukan');
        }
        try {
            MatKulModel::destroy($id); // Hapus data 
            return redirect('/matkul')->with('success', 'Data Mata Kuliah berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/matkul')->with('error', 'Data Mata Kuliah gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    // 1. public function create_ajax()
    public function create_ajax()
    {
        $user = UserModel::select('id_user', 'nama_user')->get();
        return view('matkul.create_ajax')
            ->with('user', $user);
    }
    

    // 2. public function store_ajax(Request $request)
    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_user'       => 'required|integer',
                'nama_matkul'   => 'required|string|max:50', 
                'kode_matkul'   => 'required|string|max:50' 
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

        return view('matkul.edit_ajax', ['matkul' => $matkul, 'user' => $user]);
    }

    // 4. public function update_ajax(Request $request, $id)
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_user'       => 'required|integer',
                'nama_matkul'   => 'required|string|max:50',
                'kode_matkul'   => 'required|string|max:50'  
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

    // 7. public function show_ajax(string $id)
    public function show_ajax(string $id)
    {
        $matkul = MatKulModel::find($id);
        $user = UserModel::find($matkul->id_user);

        return view('matkul.show_ajax', ['matkul' => $matkul, 'user' => $user]);
    }

    
    public function import()
    {
        return view('matkul.import');
    }
    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_matkul' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $file = $request->file('file_matkul'); // ambil file dari request
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
                            'id_user'       => $value['A'],
                            'nama_matkul'   => $value['B'],
                            'kode_matkul'   => $value['C'],
                            'created_at' => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    MatKulModel::insertOrIgnore($insert);
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
        $matkul = MatKulModel::select('id_user', 'nama_matkul', 'kode_matkul')
            ->orderBy('id_user')
            ->with('user')
            ->get();
        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama User');
        $sheet->setCellValue('C1', 'Mata Kuliah');
        $sheet->setCellValue('D1', 'Kode Mata Kuliah');
        $sheet->getStyle('A1:D1')->getFont()->setBold(true); // bold header
        $no = 1; // nomor data dimulai dari 1
        $baris = 2; // baris data dimulai dari baris ke 2
        foreach ($matkul as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->user->nama_user);
            $sheet->setCellValue('C' . $baris, $value->nama_matkul);
            $sheet->setCellValue('D' . $baris, $value->kode_matkul);
            $baris++;
            $no++;
        }
        foreach (range('A', 'D') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }
        $sheet->setTitle('Data Mata Kuliah'); // set title sheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Mata Kuliah ' . date('Y-m-d H:i:s') . '.xlsx';
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
        $matkul = MatKulModel::select('id_user', 'nama_matkul', 'kode_matkul')
            ->orderBy('id_user')
            ->with('user')
            ->get();
        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('matkul.export_pdf', ['matkul' => $matkul]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url $pdf->render();
        return $pdf->stream('Data Mata Kuliah' . date('Y-m-d H:i:s') . '.pdf');
    }
}
