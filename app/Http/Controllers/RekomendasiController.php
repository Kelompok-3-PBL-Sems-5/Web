<?php

namespace App\Http\Controllers;

use App\Models\DabimModel;
use App\Models\DamatModel;
use App\Models\RekomendasiModel;
use App\Models\UserModel;
use App\Models\VendorModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;

class rekomendasiController extends Controller
{
    // Menampilkan halaman awal rekomendasi
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar rekomendasi',
            'list'  => ['Home', 'rekomendasi']
        ];

        $page = (object) [
            'title' => 'Daftar rekomendasi yang terdaftar dalam sistem'
        ];

        $activeMenu = 'rekomendasi'; // set menu yang sedang aktif
        $rekomendasi = RekomendasiModel::all(); // set menu yang sedang aktif
        $vendor = VendorModel::all(); // ambil data vendor untuk filter vendor
        $damat = DamatModel::all();
        $dabim = DabimModel::all();
        $users = UserModel::select('id_user', 'nama_user')->get(); // Pilih hanya kolom 'id_user'
        return view('rekomendasi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'rekomendasi' => $rekomendasi, 'vendor' => $vendor, 'damat' => $damat, 'dabim' => $dabim, 'activeMenu' => $activeMenu, 'user' => $users]);
    }

    // Fungsi untuk menampilkan rekomendasi dengan filter berdasarkan user_id
    public function list(Request $request)
    {
        $rekomendasi = RekomendasiModel::select(
            't_data_rekomendasi_program.id_program',
            't_data_rekomendasi_program.id_vendor',
            't_data_rekomendasi_program.jenis_program',
            't_data_rekomendasi_program.nama_program',
            't_data_rekomendasi_program.id_matkul',
            't_data_rekomendasi_program.id_bidang_minat',
            't_data_rekomendasi_program.tanggal_program',
            't_data_rekomendasi_program.level_program',
            't_data_rekomendasi_program.kuota_program'
        )
            ->with(['vendor', 'matkul', 'bidang_minat']) // Eager loading relasi
            ->leftJoin('mata_kuliah', 't_data_rekomendasi_program.id_matkul', '=', 'mata_kuliah.id_matkul');

        
        // Jika ada filter berdasarkan user_id
        if ($request->has('user_id')) {
            $userId = $request->input('user_id');

            $rekomendasi->whereHas('matkul', function ($query) use ($userId) {
                $query->where('id_user', $userId);
            });
        }

        // Filter tambahan berdasarkan id_vendor, id_damat, atau id_dabim
        if ($request->id_vendor) {
            $rekomendasi->where('id_vendor', $request->id_vendor);
        }
        if ($request->id_damat) {
            $rekomendasi->where('id_damat', $request->id_damat);
        }
        if ($request->id_dabim) {
            $rekomendasi->where('id_dabim', $request->id_dabim);
        }

        // Return data untuk DataTables
        return DataTables::of($rekomendasi)
            ->addIndexColumn() // Menambahkan kolom index / nomor urut
            ->addColumn('aksi', function ($rekomendasi) {
                $btn = '<button onclick="modalAction(\'' . url('/rekomendasi/' . $rekomendasi->id_program) . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/rekomendasi/' . $rekomendasi->id_program . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/rekomendasi/' . $rekomendasi->id_program . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi']) // Memberitahu bahwa kolom aksi berisi HTML
            ->make(true);
    }

    private function determineStatus(string $tanggal_program): string
    {
        try {
            $now = Carbon::now();
            $program = Carbon::parse($tanggal_program);
            $akhir = Carbon::parse();

            if ($now->lt($program)) {
                return 'Belum Dimulai';
            } elseif ($now->between($program, $akhir)) {
                return 'Aktif';
            } else {
                return 'Selesai';
            }
        } catch (\Exception $e) {
            return 'Tanggal Tidak Valid'; // Tangani kasus tanggal yang tidak valid
        }
    }

    // Menampilkan detail rekomendasi
    public function show(string $id)
    {
        $rekomendasi = RekomendasiModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail rekomendasi',
            'list'  => ['Home', 'rekomendasi', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail rekomendasi'
        ];

        $activeMenu = 'rekomendasi'; // set menu yang sedang aktif

        return view('rekomendasi.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'rekomendasi' => $rekomendasi, 'activeMenu' => $activeMenu]);
    }

    // 1. public function create_ajax()
    public function create_ajax()
    {
        $vendor = VendorModel::select('id_vendor', 'nama_vendor')->get();
        $damat = DamatModel::select('id_damat', 'nama_damat')->get();
        $dabim = DabimModel::select('id_dabim', 'dabim')->get();
        return view('rekomendasi.create_ajax', ['vendor' => $vendor, 'damat' => $damat, 'dabim' => $dabim]);
    }

    // 2. public function store_ajax(Request $request)
    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_vendor'                => 'required|integer',
                'jenis_program'            => 'required|string|max:50',
                'nama_program'             => 'required|string|max:100',
                'id_damat'                => 'required|integer',
                'id_dabim'          => 'required|integer',
                'tanggal_program'          => 'required|date',
                'level_program'            => 'required|string|max:50',
                'kuota_program'            => 'required|string|max:100',
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
            RekomendasiModel::create($request->all());
            return response()->json([
                'status'    => true,
                'message'   => 'Data rekomendasi berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    // 3. public function edit_ajax(string $id)
    public function edit_ajax(string $id)
    {
        $rekomendasi = RekomendasiModel::find($id);
        $vendor = VendorModel::all(); // ambil data vendor untuk filter vendor
        $damat = DamatModel::all();
        $dabim = DabimModel::all();
        return view('rekomendasi.edit_ajax', ['rekomendasi' => $rekomendasi, 'dabim' => $dabim, 'damat' => $damat, 'vendor' => $vendor]);
    }

    // 4. public function update_ajax(Request $request, $id)
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_vendor'                => 'required|integer',
                'jenis_program'            => 'required|string|max:50',
                'nama_program'             => 'required|string|max"100',
                'id_damat'                => 'required|integer',
                'id_dabim'          => 'required|integer',
                'tanggal_program'          => 'required|date',
                'level_program'            => 'required|string|max:50',
                'kuota_program'            => 'required|string|max:100',
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
            $check = RekomendasiModel::find($id);
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
        $rekomendasi = RekomendasiModel::find($id);
        return view('rekomendasi.confirm_ajax', ['rekomendasi' => $rekomendasi]);
    }

    // 6. public function delete_ajax(Request $request, $id)
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rekomendasi = RekomendasiModel::find($id);
            if ($rekomendasi) {
                $rekomendasi->delete();
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

    // //Pertemuan 8
    // public function import()
    // {
    //     return view('rekomendasi.import');
    // }

    /* public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_rekomendasi' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $file = $request->file('file_rekomendasi'); // ambil file dari request
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
                         $rules = [
                            'id_vendor'                => $value['A'],
                            'jenis_program'            => $value['B'],
                            'nama_program'             => $value['C'],
                            'id_matkul'                => $value['D'],
                            'id_dabim'          => $value['E'],
                            'tanggal_program'          => $value['F'],
                            'level_program'            => $value['G'],
                            'kuota_program'            => $value['H'],
                            'created_at' => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    RekomendasiModel::insertOrIgnore($insert);
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
    
    /*public function export_excel()
    {
        // ambil data rekomendasi yang akan di export
        $rekomendasi = RekomendasiModel::select('nama_rekomendasi', 'alamat_rekomendasi', 'telp_rekomendasi', 'jenis_rekomendasi')
            ->orderBy('nama_rekomendasi')
            ->get();
        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', '');
        $sheet->setCellValue('C1', '');
        $sheet->setCellValue('D1', '');
        $sheet->setCellValue('E1', '');
        $sheet->getStyle('A1:E1')->getFont()->setBold(true); // bold header
        $no = 1; // nomor data dimulai dari 1
        $baris = 2; // baris data dimulai dari baris ke 2
        foreach ($rekomendasi as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->);
            $sheet->setCellValue('C' . $baris, $value->);
            $sheet->setCellValue('D' . $baris, $value->);
            $sheet->setCellValue('E' . $baris, $value->);
            $baris++;
            $no++;
        }
        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }
        $sheet->setTitle('Data rekomendasi'); // set title sheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data rekomendasi ' . date('Y-m-d H:i:s') . '.xlsx';
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
    } // end function export_excel */
    // public function export_pdf()
    // {
    //     $rekomendasi = RekomendasiModel::select('nama_rekomendasi', 'alamat_rekomendasi', 'telp_rekomendasi', 'jenis_rekomendasi')
    //         ->orderBy('nama_rekomendasi')
    //         ->get();
    //     // use Barryvdh\DomPDF\Facade\Pdf;
    //     $pdf = Pdf::loadView('rekomendasi.export_pdf', ['rekomendasi' => $rekomendasi]);
    //     $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
    //     $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url $pdf->render();
    //     return $pdf->stream('Data rekomendasi' . date('Y-m-d H:i:s') . '.pdf');
    // }
}
