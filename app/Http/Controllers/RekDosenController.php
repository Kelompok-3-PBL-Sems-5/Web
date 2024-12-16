<?php
namespace App\Http\Controllers;

use App\Models\RekDosenModel;
use App\Models\UserModel;
use App\Models\RekomendasiModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\IOFactory;

class RekDosenController extends Controller
{
    // Menampilkan halaman awal Rekomendasi Dosen
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Rekomendasi Dosen',
            'list'  => ['Home', 'Rekomendasi Dosen']
        ];

        $page = (object) [
            'title' => 'Daftar Rekomendasi Dosen yang terdaftar dalam sistem'
        ];

        $activeMenu = 'notifikasi'; // set menu yang sedang aktif
        $rekdosen = RekDosenModel::all();
        $rekomendasi = RekomendasiModel::all();
        $user = UserModel::all();
        return view('rekdosen.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'user' => $user, 'rekomendasi' => $rekomendasi, 'rekdosen' => $rekdosen]);
    }

    // Ambil data Rekomendasi Dosen dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        // Ambil data Rekomendasi Dosen
        $rekdosen = RekDosenModel::select('id_rekdosen', 'id_user','id_program', 'status')
        ->with('user')
        ->with('rekomendasi');

        if ($request->id_user) {
            $rekdosen->where('id_user', $request->id_user);
        }
        if ($request->id_program) {
            $rekdosen->where('id_program', $request->id_program);
        }

        // Return data untuk DataTables
        return DataTables::of($rekdosen)
            ->addIndexColumn() // menambahkan kolom index / nomor urut
            ->addColumn('aksi', function ($rekdosen) {
                $btn = '<button onclick="modalAction(\'' . url('/notifikasi/' . $rekdosen->id_rekdosen ) . '\')" class="btn btn-info btn-sm">Detail</a>';
                $btn .= '<button onclick="modalAction(\'' . url('/notifikasi/' . $rekdosen->id_rekdosen . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/notifikasi/' . $rekdosen->id_rekdosen . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi berisi HTML
            ->make(true);
    }


    // Menampilkan detail Rekomendasi Dosen
    public function show(string $id)
    {
        $rekdosen = RekDosenModel::with('user')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Rekomendasi Dosen',
            'list'  => ['Home', 'Rekomendasi Dosen', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Rekomendasi Dosen'
        ];

        $activeMenu = 'notifikasi'; // set menu yang sedang aktif

        return view('rekdosen.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'rekdosen' => $rekdosen, 'activeMenu' => $activeMenu]);
    }


    // 1. public function create_ajax()
    public function create_ajax()
    {
        $user = UserModel::select('id_user', 'nama_user')->get();
        $rekomendasi = RekomendasiModel::select('id_program', 'nama_program')->get();
        return view('rekdosen.create_ajax')
        ->with('user', $user)
        ->with('rekomendasi', $rekomendasi);
    }

    // 2. public function store_ajax(Request $request)
    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_user'    => 'required|integer',
                'id_program' => 'required|integer',
                'status' => 'required|string|max:100',

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
            RekDosenModel::create([
                'id_user'        => $request->id_user,
                'id_program'     => $request->id_program,
                'status'         => $request->status
            ]);
            return response()->json([
                'status'    => true,
                'message'   => 'Data Rekomendasi Dosen berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    // 3. public function edit_ajax(string $id)
    public function edit_ajax(string $id)
    {
        $rekdosen = RekDosenModel::find($id);
        $user = UserModel::select('id_user', 'nama_user')->get();
        $rekomendasi = RekomendasiModel::select('id_program', 'nama_program')->get();

        return view('rekdosen.edit_ajax', ['rekdosen' => $rekdosen, 'user' => $user, 'rekomendasi' => $rekomendasi]);
    }

    // 4. public function update_ajax(Request $request, $id)
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_user'    => 'required|integer',
                'id_program' => 'required|integer',
                'status' => 'required|string|max:100'

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
            $check = RekDosenModel::find($id);
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
        $rekdosen = RekDosenModel::find($id);
        return view('rekdosen.confirm_ajax', ['rekdosen' => $rekdosen]);
    }

    // 6. public function delete_ajax(Request $request, $id)
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rekdosen = RekDosenModel::find($id);
            if ($rekdosen) {
                $rekdosen->delete();
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


    //Pertemuan 8
    // public function import()
    // {
    //     return view('rekdosen.import');
    // }
    // public function import_ajax(Request $request)
    // {
    //     if ($request->ajax() || $request->wantsJson()) {
    //         $rules = [
    //             // validasi file harus xls atau xlsx, max 1MB
    //             'file_prodi' => ['required', 'mimes:xlsx', 'max:1024']
    //         ];
    //         $validator = Validator::make($request->all(), $rules);
    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Validasi Gagal',
    //                 'msgField' => $validator->errors()
    //             ]);
    //         }
    //         $file = $request->file('file_prodi'); // ambil file dari request
    //         $reader = IOFactory::createReader('Xlsx'); // load reader file excel
    //         $reader->setReadDataOnly(true); // hanya membaca data
    //         $spreadsheet = $reader->load($file->getRealPath()); // load file excel
    //         $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
    //         $data = $sheet->toArray(null, false, true, true); // ambil data excel
    //         $insert = [];
    //         if (count($data) > 1) { // jika data lebih dari 1 baris
    //             foreach ($data as $baris => $value) {
    //                 if ($baris > 1) { // baris ke 1 adalah header, maka lewati
    //                     $insert[] = [
    //                         'id_user'                  => $value['A'],
    //                         'kode_prodi'               => $value['B'],
    //                         'nama_prodi'               => $value['C'],
    //                         'jenjang'                  => $value['D'],
    //                         'created_at' => now(),
    //                     ];
    //                 }
    //             }
    //             if (count($insert) > 0) {
    //                 // insert data ke database, jika data sudah ada, maka diabaikan
    //                 RekDosenModel::insertOrIgnore($insert);
    //             }
    //             return response()->json([
    //                 'status' => true,
    //                 'message' => 'Data berhasil diimport'
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Tidak ada data yang diimport'
    //             ]);
    //         }
    //     }
    //     return redirect('/');
    // }
    // public function export_excel()
    // {
    //     // ambil data barang yang akan di export
    //     $rekdosen = RekDosenModel::select('id_user','kode_prodi', 'nama_prodi', 'jenjang')
    //         ->orderBy('id_user')
    //         ->with('user')
    //         ->get();
    //     // load library excel
    //     $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
    //     $sheet->setCellValue('A1', 'No');
    //     $sheet->setCellValue('B1', 'Nama User');
    //     $sheet->setCellValue('C1', 'Kode Prodi');
    //     $sheet->setCellValue('D1', 'Nama Prodi');
    //     $sheet->setCellValue('E1', 'Jenjang');

    //     $sheet->getStyle('A1:E1')->getFont()->setBold(true); // bold header
    //     $no = 1; // nomor data dimulai dari 1
    //     $baris = 2; // baris data dimulai dari baris ke 2
    //     foreach ($rekdosen as $key => $value) {
    //         $sheet->setCellValue('A' . $baris, $no);
    //         $sheet->setCellValue('B' . $baris, $value->user->nama_user);
    //         $sheet->setCellValue('C' . $baris, $value->kode_prodi);
    //         $sheet->setCellValue('D' . $baris, $value->nama_prodi);
    //         $sheet->setCellValue('E' . $baris, $value->jenjang);
    //         $baris++;
    //         $no++;
    //     }
    //     foreach (range('A', 'E') as $columnID) {
    //         $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
    //     }
    //     $sheet->setTitle('Data Prodi'); // set title sheet
    //     $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    //     $filename = 'Data Prodi ' . date('Y-m-d H:i:s') . '.xlsx';
    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachment;filename="' . $filename . '"');
    //     header('Cache-Control: max-age=0');
    //     header('Cache-Control: max-age=1');
    //     header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    //     header('Last-Modified:' . gmdate('D, d M Y H:i:s') . ' GMT');
    //     header('Cache-Control: cache, must-revalidate');
    //     header('Pragma: public');
    //     $writer->save('php://output');
    //     exit;
    // } // end function export_excel
    // public function export_pdf()
    // {
    //     $rekdosen = RekDosenModel::select('id_user', 'kode_prodi', 'nama_prodi', 'jenjang')
    //         ->orderBy('id_user')
    //         ->with('user')
    //         ->get();
    //     // use Barryvdh\DomPDF\Facade\Pdf;
    //     $pdf = Pdf::loadView('prodi.export_pdf', ['prodi' => $rekdosen]);
    //     $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
    //     $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url $pdf->render();
    //     return $pdf->stream('Data prodi' . date('Y-m-d H:i:s') . '.pdf');
    // }
}