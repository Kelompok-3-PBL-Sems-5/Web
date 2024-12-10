<?php
namespace App\Http\Controllers;
use App\Models\VendorModel;
use App\Models\SertifikasiModel;
use App\Models\UserModel;
use App\Models\BidangMinatModel;
use App\Models\MatKulModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class SertifikasiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Sertifikasi',
            'list' => ['Home', 'Sertifikasi']
        ];
        $page = (object) [
            'title' => 'Daftar Sertifikasi yang terdaftar dalam sistem'
        ];
        $activeMenu = 'data_sertifikasi'; // set menu yang sedang aktif
        $sertifikasi = SertifikasiModel::all(); // Ambil semua data sertifikasi dari database
        $vendor = VendorModel::all(); // ambil data vendor untuk filter vendor
        $user = UserModel::all(); // ambil data user untuk filter user
        $bidang_minat = BidangMinatModel::all();
        $matkul = MatKulModel::all();
        return view('sertifikasi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'vendor' => $vendor, 'user' => $user, 'bidang_minat' => $bidang_minat, 'matkul' => $matkul, 'activeMenu' => $activeMenu, 'sertifikasi' => $sertifikasi]);
    }
    
    // Ambil data sertifikasi dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $sertifikasi = SertifikasiModel::select('id_sertifikasi', 'id_user','id_vendor','id_bidang_minat', 'id_matkul','nama_sertif', 'jenis_sertif', 'tgl_mulai_sertif', 'tgl_akhir_sertif', 'jenis_pendanaan_sertif', 'bukti_sertif', 'status')
            ->with('vendor')
            ->with('bidang_minat')
            ->with('matkul')
            ->with('user');
        // filter data sertifikasi berdasarkan id_vendor dan id_user
        if ($request->id_vendor) {
            $sertifikasi->where('id_vendor', $request->id_vendor);
        }
        if ($request->id_user) {
            $sertifikasi->where('id_user', $request->id_user);
        }
        if ($request->id_bidang_minat) {
            $sertifikasi->where('id_bidang_minat', $request->id_bidang_minat);
        }
        if ($request->id_matkul) {
            $sertifikasi->where('id_matkul', $request->id_matkul);
        }
        
        return DataTables::of($sertifikasi)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($sertifikasi) { // menambahkan kolom aksi
                // $btn = '<a href="' . url('/data_sertifikasi/' . $sertifikasi->id_sertifikasi) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn = '<button onclick="modalAction(\'' . url('/data_sertifikasi/' . $sertifikasi->id_sertifikasi ) . '\')" class="btn btn-info btn-sm">Detail</a>';
                $btn .= '<button onclick="modalAction(\'' . url('/data_sertifikasi/' . $sertifikasi->id_sertifikasi . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/data_sertifikasi/' . $sertifikasi->id_sertifikasi . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    // Menampilkan halaman form tambah sertifikasi 
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Sertifikasi',
            'list' => ['Home', 'Sertifikasi', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah Sertifikasi baru'
        ];
        $vendor = VendorModel::all(); // ambil data vendor untuk filter vendor
        $user = UserModel::all(); // ambil data user untuk filter user
        $bidang_minat = BidangMinatModel::all();
        $matkul = MatKulModel::all();
        $activeMenu = 'sertifikasi'; // set menu yang sedang aktif
        return view('sertifikasi.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'vendor' => $vendor, 'user' => $user,'bidang_minat' => $bidang_minat, 'matkul' => $matkul, 'activeMenu' => $activeMenu]);
    }

    // Fungsi untuk menentukan status berdasarkan tanggal mulai dan akhir
    private function determineStatus(string $tgl_mulai_sertif, string $tgl_akhir_sertif): string
    {
        try {
            $now = Carbon::now();
            $mulai = Carbon::parse($tgl_mulai_sertif);
            $akhir = Carbon::parse($tgl_akhir_sertif);

            if ($now->lt($mulai)) {
                return 'Belum Dimulai';
            } elseif ($now->between($mulai, $akhir)) {
                return 'Aktif';
            } else {
                return 'Selesai';
            }
        } catch (\Exception $e) {
            return 'Tanggal Tidak Valid'; // Tangani kasus tanggal yang tidak valid
        }
    }

    // Menampilkan detail sertifikasi
    public function show(string $id)
    {
        $sertifikasi = SertifikasiModel::with('vendor')->find($id);
        $breadcrumb = (object) ['title' => 'Detail sertifikasi', 'list' => ['Home', 'Sertifikasi', 'Detail']];
        $page = (object) ['title' => 'Detail sertifikasi'];
        $activeMenu = 'sertifikasi'; // set menu yang sedang aktif
        return view('sertifikasi.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'sertifikasi' => $sertifikasi, 'activeMenu' => $activeMenu]);
    }
    // Menampilkan halaman fore edit sertifikasi 
    public function edit(string $id)
    {
        $sertifikasi = SertifikasiModel::find($id);
        $vendor = VendorModel::all(); // Ambil data vendor
        $user = UserModel::all(); // Ambil data user
        $bidang_minat = BidangMinatModel::all();
        $matkul = MatKulModel::all();
        $breadcrumb = (object) [
            'title' => 'Edit Sertifikasi',
            'list' => ['Home', 'Sertifikasi', 'Edit']
        ];
        $page = (object) [
            "title" => 'Edit Sertifikasi'
        ];
        $activeMenu = 'sertifikasi'; // set menu yang sedang aktif
        return view('sertifikasi.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'sertifikasi'=> $sertifikasi, 'vendor' => $vendor, 'user' => $user,'bidang_minat' => $bidang_minat, 'matkul' => $matkul, 'activeMenu' => $activeMenu]);
    }

    // Menghapus data sertifikasi 
    public function destroy(string $id)
    {
        $check = SertifikasiModel::find($id);
        if (!$check) {      // untuk mengecek apakah data sertifikasi dengan id yang dimaksud ada atau tidak
            return redirect('/data_sertifikasi')->with('error', 'Data sertifikasi tidak ditemukan');
        }
        try {
            SertifikasiModel::destroy($id); // Hapus data supplier
            return redirect('/data_sertifikasi')->with('success', 'Data sertifikasi berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/data_sertifikasi')->with('error', 'Data sertifikasi gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    // 1. public function create_ajax()
    public function create_ajax()
    {
        $vendor = VendorModel::select('id_vendor', 'nama_vendor')->get();
        $user = UserModel::select('id_user', 'nama_user')->get();
        $bidang_minat = BidangMinatModel::select('id_bidang_minat', 'bidang_minat')->get();
        $matkul = MatKulModel::select('id_matkul', 'nama_matkul')->get();
        return view('sertifikasi.create_ajax')
            ->with('vendor', $vendor)
            ->with('user', $user)
            ->with('bidang_minat', $bidang_minat)
            ->with('matkul', $matkul);
    }
    

    // 2. public function store_ajax(Request $request)
    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            // Aturan validasi
            $rules = [
                'id_user'                  => 'required|integer',
                'id_vendor'                => 'required|integer',
                'id_matkul'                => 'required|integer',
                'id_bidang_minat'          => 'required|integer',
                'nama_sertif'              => 'required|string|max:100',
                'jenis_sertif'             => 'required|string|max:50',
                'tgl_mulai_sertif'         => 'required|date',
                'tgl_akhir_sertif'         => 'required|date',
                'jenis_pendanaan_sertif'   => 'required|string|max:50',
                'bukti_sertif'             => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }

            // // Menangani upload file
            // $filePath = null; // Default jika tidak ada file yang diupload
            // if ($request->hasFile('bukti_sertif')) {
            //     $file = $request->file('bukti_sertif');
            //     $extension = $file->getClientOriginalExtension();
            //     $filename = time() . '.' . $extension;
            //     $path = 'image/bukti/'; // Folder tujuan untuk file yang diupload
            //     $file->move(public_path($path), $filename); // Menyimpan file di folder public/image/bukti
            //     $filePath = $path . $filename; // Menyimpan path file di database
            // }

        
            // Simpan ke database
            SertifikasiModel::create($request->all());
            return response()->json([
                'status'    => true,
                'message'   => 'Data vendor berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    // 3. public function edit_ajax(string $id)
    public function edit_ajax(string $id)
    {
        $sertifikasi = SertifikasiModel::find($id);
        $vendor = VendorModel::select('id_vendor', 'nama_vendor')->get();
        $user = UserModel::select('id_user', 'nama_user')->get();
        $bidang_minat = BidangMinatModel::select('id_bidang_minat', 'bidang_minat')->get();
        $matkul = MatKulModel::select('id_matkul', 'nama_matkul')->get();

        return view('sertifikasi.edit_ajax', ['sertifikasi' => $sertifikasi, 'vendor' => $vendor, 'user' => $user, 'bidang_minat' => $bidang_minat, 'matkul' => $matkul]);
    }

    // 4. public function update_ajax(Request $request, $id)
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            // Aturan validasi
            $rules = [
                'id_user'                  => 'required|integer',
                'id_vendor'                => 'required|integer',
                'id_matkul'                => 'required|integer',
                'id_bidang_minat'          => 'required|integer',
                'nama_sertif'              => 'required|string|max:100',
                'jenis_sertif'             => 'required|string|max:50',
                'tgl_mulai_sertif'         => 'required|date',
                'tgl_akhir_sertif'         => 'required|date',
                'jenis_pendanaan_sertif'   => 'required|string|max:50',
                'bukti_sertif'             => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }

            $check = SertifikasiModel::find($id);
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
        $sertifikasi = SertifikasiModel::find($id);
        return view('sertifikasi.confirm_ajax', ['sertifikasi' => $sertifikasi]);
    }

    // 6. public function delete_ajax(Request $request, $id)
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $sertifikasi = SertifikasiModel::find($id);
            if ($sertifikasi) {
                $sertifikasi->delete();
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
        $sertifikasi = SertifikasiModel::find($id);

        $vendor = VendorModel::find($sertifikasi->id_vendor);
        $user = UserModel::find($sertifikasi->id_user);
        $bidang_minat = BidangMinatModel::find($sertifikasi->id_bidang_minat);
        $matkul = MatKulModel::find($sertifikasi->id_matkul);

        return view('sertifikasi.show_ajax', ['sertifikasi' => $sertifikasi, 'vendor' => $vendor, 'user' => $user, 'bidang_minat' => $bidang_minat, 'matkul' => $matkul]);
    }

    
    public function import()
    {
        return view('sertifikasi.import');
    }
    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_sertifikasi' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $file = $request->file('file_sertifikasi'); // ambil file dari request
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
                            'id_vendor'                => $value['B'],
                            'id_matkul'                => $value['C'],
                            'id_bidang_minat'          => $value['D'],
                            'nama_sertif'              => $value['E'],
                            'jenis_sertif'             => $value['F'],
                            'tgl_mulai_sertif'         => $value['G'],
                            'tgl_akhir_sertif'         => $value['H'],
                            'jenis_pendanaan_sertif'   => $value['I'],
                            'bukti_sertif'             => $value['J'],
                            'status'                   => $value['K'],
                            'created_at' => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    SertifikasiModel::insertOrIgnore($insert);
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
        $sertifikasi = SertifikasiModel::select('id_user','id_vendor','id_matkul','id_bidang_minat','nama_sertif', 'jenis_sertif', 'tgl_mulai_sertif', 'tgl_akhir_sertif', 'jenis_pendanaan_sertif', 'bukti_sertif', 'status')
            ->orderBy('id_user')
            ->with('user')
            ->with('vendor')
            ->with('matkul')
            ->with('bidang_minat')
            ->get();
        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama User');
        $sheet->setCellValue('C1', 'Nama Vendor');
        $sheet->setCellValue('D1', 'Nama Mata Kuliah');
        $sheet->setCellValue('E1', 'Nama Bidang Minat');
        $sheet->setCellValue('F1', 'Nama Sertifikasi');
        $sheet->setCellValue('G1', 'Jenis Sertifikasi');
        $sheet->setCellValue('H1', 'Tanggal Mulai');
        $sheet->setCellValue('I1', 'Tanggal Akhir');
        $sheet->setCellValue('J1', 'Jenis Pendanaan');
        $sheet->setCellValue('K1', 'Bukti Sertifikasi');
        $sheet->setCellValue('L1', 'Status');

        $sheet->getStyle('A1:L1')->getFont()->setBold(true); // bold header
        $no = 1; // nomor data dimulai dari 1
        $baris = 2; // baris data dimulai dari baris ke 2
        foreach ($sertifikasi as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->user->nama_user);
            $sheet->setCellValue('C' . $baris, $value->vendor->nama_vendor);
            $sheet->setCellValue('D' . $baris, $value->matkul->nama_matkul);
            $sheet->setCellValue('E' . $baris, $value->bidang_minat->bidang_minat);
            $sheet->setCellValue('F' . $baris, $value->nama_sertif);
            $sheet->setCellValue('G' . $baris, $value->jenis_sertif);
            $sheet->setCellValue('H' . $baris, $value->tgl_mulai_sertif);
            $sheet->setCellValue('I' . $baris, $value->tgl_akhir_sertif);
            $sheet->setCellValue('J' . $baris, $value->jenis_pendanaan_sertif);
            $sheet->setCellValue('K' . $baris, $value->bukti_sertif);
            $sheet->setCellValue('L' . $baris, $value->status);
            $baris++;
            $no++;
        }
        foreach (range('A', 'L') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }
        $sheet->setTitle('Data Sertifikasi'); // set title sheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Sertifikasi ' . date('Y-m-d H:i:s') . '.xlsx';
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
        $sertifikasi = SertifikasiModel::select('id_user','id_vendor', 'id_matkul','id_bidang_minat','nama_sertif', 'jenis_sertif', 'tgl_mulai_sertif', 'tgl_akhir_sertif', 'jenis_pendanaan_sertif', 'bukti_sertif', 'status')
            ->orderBy('id_user')    
            ->orderBy('id_vendor')
            ->with('user')
            ->with('vendor')
            ->with('matkul')
            ->with('bidang_minat')
            ->get();
        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('sertifikasi.export_pdf', ['sertifikasi' => $sertifikasi]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url $pdf->render();
        return $pdf->stream('Data sertifikasi' . date('Y-m-d H:i:s') . '.pdf');
    }
}
