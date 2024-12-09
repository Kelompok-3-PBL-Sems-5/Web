<?php
namespace App\Http\Controllers;

use App\Models\BidangMinatModel;
use App\Models\MatKulModel;
use App\Models\RekomendasiModel;
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
        $matkul = MatKulModel::all();
        $bidang_minat = BidangMinatModel::all();
        return view('rekomendasi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'rekomendasi' => $rekomendasi, 'vendor' => $vendor, 'matkul' => $matkul, 'bidang_minat' => $bidang_minat, 'activeMenu' => $activeMenu]);
    }

    // Ambil data rekomendasi dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        // Ambil data rekomendasi
        $rekomendasi = RekomendasiModel::select('id_program', 'id_vendor', 'jenis_program', 'nama_program', 'id_matkul', 'id_bidang_minat', 'tanggal_program', 'level_program', 'kuota_program')
            ->with('vendor')
            ->with('matkul')
            ->with('bidang_minat');

            if ($request->id_vendor) {
                $rekomendasi->where('id_vendor', $request->id_vendor);
            }
            if ($request->id_matkul) {
                $rekomendasi->where('id_matkul', $request->id_matkul);
            }
            if ($request->id_bidang_minat) {
                $rekomendasi->where('id_bidang_minat', $request->id_bidang_minat);
            }
        // Return data untuk DataTables
        return DataTables::of($rekomendasi)
            ->addIndexColumn() // menambahkan kolom index / nomor urut
            ->addColumn('aksi', function ($rekomendasi) {
                // Menambahkan kolom aksi untuk edit, detail, dan hapus
                // $btn = '<a href="' . url('/rekomendasi/' . $rekomendasi->id_program) . '" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="' . url('/rekomendasi/' . $rekomendasi->id_program . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/rekomendasi/' . $rekomendasi->id_program) . '">'
                //     . csrf_field() . method_field('DELETE') .
                //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                // return $btn;

                // $btn = '<a href="' . url('/rekomendasi/' . $rekomendasi->id_program) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn = '<button onclick="modalAction(\'' . url('/rekomendasi/' . $rekomendasi->id_program ) . '\')" class="btn btn-info btn-sm">Detail</a>';
                $btn .= '<button onclick="modalAction(\'' . url('/rekomendasi/' . $rekomendasi->id_program . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/rekomendasi/' . $rekomendasi->id_program . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi berisi HTML
            ->make(true);
    }

    // Menampilkan halaman form tambah rekomendasi
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah rekomendasi',
            'list'  => ['Home', 'rekomendasi', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah rekomendasi baru'
        ];
        // $vendor = VendorModel::all(); // ambil data vendor untuk filter vendor
        $matkul = MatKulModel::all();
        // $bidang_minat = BidangMinatModel::all();
        $activeMenu = 'rekomendasi'; // set menu yang sedang aktif
        return view('rekomendasi.create', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'activeMenu' => $activeMenu
        ]);
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

    // Menyimpan data rekomendasi baru
    public function store(Request $request)
    {
        $request->validate([
            'jenis_program' => 'jenis_program',
            'nama_program'=> 'nama_program', 
            'tanggal_program' => 'tanggal_program',
            'level_program' => 'level_program',
            'kuota_program' => 'kuota_program'
        ]);

        RekomendasiModel::create([
            'jenis_program' => $request->jenis_program,
            'nama_program'=> $request->nama_program, 
            'tanggal_program' => $request->tanggal_program,
            'level_program' => $request->level_program,
            'kuota_program' => $request->kuota_program
        ]);

        return redirect('/rekomendasi')->with('success', 'Data rekomendasi berhasil disimpan');
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
    public function show_ajax(string $id)
    {
        $rekomendasi = RekomendasiModel::find($id);
        $vendor = VendorModel::select('id_vendor', 'nama_vendor')->get();
        $matkul = MatKulModel::select('id_matkul', 'nama_matkul')->get();
        $bidang_minat = BidangMinatModel::select('id_bidang_minat', 'bidang_minat')->get();

        return view('rekomendasi.show_ajax', ['rekomendasi' => $rekomendasi, 'matkul' => $matkul, 'bidang_minat' => $bidang_minat, 'vendor' => $vendor]);
    }

    // Menampilkan halaman form edit rekomendasi
    public function edit(string $id)
    {
        $rekomendasi = RekomendasiModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit rekomendasi',
            'list'  => ['Home', 'rekomendasi', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit rekomendasi'
        ];

        $activeMenu = 'rekomendasi'; // set menu yang sedang aktif

        return view('rekomendasi.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'rekomendasi' => $rekomendasi, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan perubahan data rekomendasi
    public function update(Request $request, string $id)
    {
        $request->validate([
           'jenis_program' => 'jenis_program',
            'nama_program'=> 'nama_program', 
            'tanggal_program' => 'tanggal_program',
            'level_program' => 'level_program',
            'kuota_program' => 'kuota_program'
        ]);

        RekomendasiModel::find($id)->update([
            'jenis_program' => $request->jenis_program,
            'nama_program'=> $request->nama_program, 
            'tanggal_program' => $request->tanggal_program,
            'level_program' => $request->level_program,
            'kuota_program' => $request->kuota_program
        ]);

        return redirect('/rekomendasi')->with('success', 'Data rekomendasi berhasil diubah');
    }

    // Menghapus data rekomendasi
    public function destroy(string $id)
    {
        $check = RekomendasiModel::find($id);
        if (!$check) {  
            return redirect('/rekomendasi')->with('error', 'Data rekomendasi tidak ditemukan');
        }

        try {
            RekomendasiModel::destroy($id); 

            return redirect('/rekomendasi')->with('success', 'Data rekomendasi berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/rekomendasi')->with('error', 'Data rekomendasi gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    // 1. public function create_ajax()
    public function create_ajax()
    {
        $vendor = VendorModel::select('id_vendor', 'nama_vendor')->get();
        $matkul = MatKulModel::select('id_matkul', 'nama_matkul')->get();
        $bidang_minat = BidangMinatModel::select('id_bidang_minat', 'bidang_minat')->get();
        return view('rekomendasi.create_ajax', ['vendor' => $vendor, 'matkul' => $matkul, 'bidang_minat' => $bidang_minat]);
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
                'id_matkul'                => 'required|integer',
                'id_bidang_minat'          => 'required|integer',
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
        $matkul = MatKulModel::all();
        $bidang_minat = BidangMinatModel::all();
        return view('rekomendasi.edit_ajax', ['rekomendasi' => $rekomendasi, 'bidang_minat' => $bidang_minat, 'matkul' => $matkul, 'vendor' => $vendor]);
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
                'id_matkul'                => 'required|integer',
                'id_bidang_minat'          => 'required|integer',
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

    //Pertemuan 8
    public function import()
    {
        return view('rekomendasi.import');
    }
    
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
                            'id_bidang_minat'          => $value['E'],
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
    public function export_pdf()
    {
        $rekomendasi = RekomendasiModel::select('nama_rekomendasi', 'alamat_rekomendasi', 'telp_rekomendasi', 'jenis_rekomendasi')
            ->orderBy('nama_rekomendasi')
            ->get();
        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('rekomendasi.export_pdf', ['rekomendasi' => $rekomendasi]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url $pdf->render();
        return $pdf->stream('Data rekomendasi' . date('Y-m-d H:i:s') . '.pdf');
    }
}