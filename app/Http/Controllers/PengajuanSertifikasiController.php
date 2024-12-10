<?php
namespace App\Http\Controllers;
use App\Models\VendorModel;
use App\Models\PengajuanSertifikasiModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PengajuanSertifikasiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Pengajuan Sertifikasi',
            'list' => ['Home', 'Pengajuan Sertifikasi']
        ];
        $page = (object) [
            'title' => 'Daftar Pengajuan Sertifikasi yang terdaftar dalam sistem'
        ];
        $activeMenu = 'ajukan_sertifikasi'; // set menu yang sedang aktif
        $pengajuan_sertifikasi = PengajuanSertifikasiModel::all(); // Ambil semua data Pengajuan Sertifikasi dari database
        $vendor = VendorModel::all(); // ambil data vendor untuk filter vendor
        $user = UserModel::all(); // ambil data user untuk filter user
        return view('pengajuan_sertifikasi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'vendor' => $vendor, 'user' => $user, 'activeMenu' => $activeMenu, 'pengajuan_sertifikasi' => $pengajuan_sertifikasi]);
    }
    
    // Ambil data Pengajuan Sertifikasi dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $pengajuan_sertifikasi = PengajuanSertifikasiModel::select( 
                                    'id_pengsertifikasi', 
                                    'id_user', 
                                    'judul', 
                                    'id_vendor',
                                    'tujuan',
                                    'relevansi',
                                    'tanggal',
                                    'lokasi',
                                    'biaya',
                                    'dana',
                                    'implementasi',
                                    'link',
                                    'status',
                                    'komentar')
            ->with('vendor')
            ->with('user');
        // filter data Pengajuan Sertifikasi berdasarkan id_vendor dan id_user
        if ($request->id_vendor) {
            $pengajuan_sertifikasi->where('id_vendor', $request->id_vendor);
        }
        if ($request->id_user) {
            $pengajuan_sertifikasi->where('id_user', $request->id_user);
        }
        
        return DataTables::of($pengajuan_sertifikasi)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($pengajuan_sertifikasi) { // menambahkan kolom aksi
                // $btn = '<a href="' . url('/data_sertifikasi/' . $pengajuan_sertifikasi->id_sertifikasi) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn = '<button onclick="modalAction(\'' . url('/ajukan_sertifikasi/' . $pengajuan_sertifikasi->id_sertifikasi ) . '\')" class="btn btn-info btn-sm">Detail</button>';
                $btn .= '<button onclick="modalAction(\'' . url('/ajukan_sertifikasi/' . $pengajuan_sertifikasi->id_sertifikasi . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/ajukan_sertifikasi/' . $pengajuan_sertifikasi->id_sertifikasi . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    // Menampilkan halaman form tambah Pengajuan Sertifikasi 
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Sertifikasi',
            'list' => ['Home', 'Sertifikasi', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah Pengajuan Sertifikasi baru'
        ];
        $vendor = VendorModel::all(); // ambil data vendor untuk filter vendor
        $user = UserModel::all(); // ambil data user untuk filter user
        $activeMenu = 'ajukan_sertifikasi'; // set menu yang sedang aktif
        return view('pengajuan_sertifikasi.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'vendor' => $vendor, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    // Fungsi untuk menentukan status 
    private function determineStatus(string $status_awal = 'Terkirim'): string
    {
        try {
            // Jika status awal diatur sebagai 'Terkirim', langsung return statusnya
            if ($status_awal === 'Terkirim') {
                return 'Terkirim'; // Status default saat upload
            }

            // Kembalikan status berdasarkan keputusan pimjur
            return $status_awal; // Bisa 'Disetujui' atau 'Ditolak'
            
        } catch (\Exception $e) {
            return 'Status Tidak Valid'; // Tangani kasus status yang tidak valid
        }
    }


    // Menampilkan detail sertifikasi
    public function show(string $id)
    {
        $pengajuan_sertifikasi = PengajuanSertifikasiModel::with('vendor')->find($id);
        $breadcrumb = (object) ['title' => 'Detail pengajuan sertifikasi', 'list' => ['Home', 'Pengajuan Sertifikasi', 'Detail']];
        $page = (object) ['title' => 'Detail sertifikasi'];
        $activeMenu = 'ajukan_sertifikasi'; // set menu yang sedang aktif
        return view('pengajuansertifikasi.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'pengajuan_sertifikasi' => $pengajuan_sertifikasi, 'activeMenu' => $activeMenu]);
    }
    // Menampilkan halaman fore edit Pengajuan Sertifikasi 
    public function edit(string $id)
    {
        $pengajuan_sertifikasi = PengajuanSertifikasiModel::find($id);
        $vendor = VendorModel::all(); // Ambil data vendor
        $user = UserModel::all(); // Ambil data user
        $breadcrumb = (object) [
            'title' => 'Edit Pengajuan Sertifikasi',
            'list' => ['Home', 'Pengajuan Sertifikasi', 'Edit']
        ];
        $page = (object) [
            "title" => 'Edit Pengajuan Sertifikasi'
        ];
        $activeMenu = 'ajukan_sertifikasi'; // set menu yang sedang aktif
        return view('pengajuan_sertifikasi.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'pengajuan_sertifikasi'=> $pengajuan_sertifikasi, 'vendor' => $vendor, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    // Menghapus data Pengajuan Sertifikasi 
    public function destroy(string $id)
    {
        $check = PengajuanSertifikasiModel::find($id);
        if (!$check) {      // untuk mengecek apakah data Pengajuan Sertifikasi dengan id yang dimaksud ada atau tidak
            return redirect('/ajukan_sertifikasi')->with('error', 'Data Pengajuan Sertifikasi tidak ditemukan');
        }
        try {
            PengajuanSertifikasiModel::destroy($id); // Hapus data supplier
            return redirect('/ajukan_sertifikasi')->with('success', 'Data Pengajuan Sertifikasi berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/ajukan_sertifikasi')->with('error', 'Data Pengajuan Sertifikasi gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    // 1. public function create_ajax()
    public function create_ajax()
    {
        $vendor = VendorModel::select('id_vendor', 'nama_vendor')->get();
        $user = UserModel::select('id_user', 'nama_user')->get();
        return view('pengajuan_sertifikasi.create_ajax')
            ->with('vendor', $vendor)
            ->with('user', $user);
    }
    

    // 2. public function store_ajax(Request $request)
    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            // Aturan validasi
            $rules = [
                'id_user'                => 'required|integer',
                'judul'                  => 'required|string|max:100', // Anda bisa sesuaikan panjang maksimalnya
                'id_vendor'              => 'required|integer',
                'tujuan'                 => 'required|string|max:100',
                'relevansi'              => 'required|string|max:100',
                'tanggal'                => 'required|date',
                'lokasi'                 => 'required|string|max:50',  // Menyimpan lokasi (Online/Offline)
                'biaya'                  => 'required|integer',  // Biaya harus berupa angka
                'dana'                   => 'required|string|max:50',  // Sumber Dana (misalnya: APBN, pribadi, dll.)
                'implementasi'           => 'required|string|max:100',
                'link'                   => 'nullable|url|max:200',  // Link Informasi Resmi, boleh kosong tapi jika ada harus URL yang valid
                'status'                 => 'required|string|max:50', // Status harus salah satu dari Terkirim, Disetujui, Ditolak
                'komentar'               => 'nullable|string|max:100', // Komentar pimjur, boleh kosong tapi jika ada, maksimal 500 karakter
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }

            // Status diatur langsung ke "Terkirim"
            $status = 'Terkirim';

            // Menyimpan data Pengajuan Sertifikasi baru
            PengajuanSertifikasiModel::create([
                'id_user'                  => $request->id_user,
                'id_vendor'                => $request->id_vendor,
                'judul'                    => $request->judul,
                'tujuan'                   => $request->tujuan,
                'relevansi'                => $request->relevansi,
                'tanggal'                  => $request->tanggal,
                'lokasi'                   => $request->lokasi,
                'biaya'                    => $request->biaya,
                'dana'                     => $request->dana,
                'implementasi'             => $request->implementasi,
                'link'                     => $request->link,
                'komentar'                 => $request->komentar,
                'status'                   => $status, // Status langsung diatur ke "Terkirim"
            ]);
            return response()->json([
                'status'    => true,
                'message'   => 'Data Pengajuan Sertifikasi berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    // 3. public function edit_ajax(string $id)
    public function edit_ajax(string $id)
    {
        $pengajuan_sertifikasi = PengajuanSertifikasiModel::find($id);
        $vendor = VendorModel::select('id_vendor', 'nama_vendor')->get();
        $user = UserModel::select('id_user', 'nama_user')->get();

        return view('pengajuan_sertifikasi.edit_ajax', ['pengajuan_sertifikasi' => $pengajuan_sertifikasi, 'vendor' => $vendor, 'user' => $user]);
    }

    // 4. public function update_ajax(Request $request, $id)
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            // Aturan validasi
            $rules = [
                'id_user'                => 'required|integer',
                'judul'                  => 'required|string|max:100', // Anda bisa sesuaikan panjang maksimalnya
                'id_vendor'              => 'required|integer',
                'tujuan'                 => 'required|string|max:100',
                'relevansi'              => 'required|string|max:100',
                'tanggal'                => 'required|date',
                'lokasi'                 => 'required|string|max:50',  // Menyimpan lokasi (Online/Offline)
                'biaya'                  => 'required|integer',  // Biaya harus berupa angka
                'dana'                   => 'required|string|max:50',  // Sumber Dana (misalnya: APBN, pribadi, dll.)
                'implementasi'           => 'required|string|max:100',
                'link'                   => 'nullable|url|max:200',  // Link Informasi Resmi, boleh kosong tapi jika ada harus URL yang valid
                'status'                 => 'required|string|max:50', // Status harus salah satu dari Terkirim, Disetujui, Ditolak
                'komentar'               => 'nullable|string|max:100', // Komentar pimjur, boleh kosong tapi jika ada, maksimal 500 karakter
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }

            // Mencari data Pengajuan Sertifikasi yang akan diupdate
            $pengajuan_sertifikasi = PengajuanSertifikasiModel::find($id);
            
            if ($pengajuan_sertifikasi) {
                // Update data sertifikasi
                $pengajuan_sertifikasi->update([
                    'id_user'                  => $request->id_user,
                    'id_vendor'                => $request->id_vendor,
                    'judul'                    => $request->judul,
                    'tujuan'                   => $request->tujuan,
                    'relevansi'                => $request->relevansi,
                    'tanggal'                  => $request->tanggal,
                    'lokasi'                   => $request->lokasi,
                    'biaya'                    => $request->biaya,
                    'dana'                     => $request->dana,
                    'implementasi'             => $request->implementasi,
                    'link'                     => $request->link,
                    'komentar'                 => $request->komentar,
                    'status'                   => $request->status, // Tidak perlu ubah status jika tidak diperlukan
                ]);
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
        $pengajuan_sertifikasi = PengajuanSertifikasiModel::find($id);
        return view('pengajuan_sertifikasi.confirm_ajax', ['pengajuan_sertifikasi' => $pengajuan_sertifikasi]);
    }

    // 6. public function delete_ajax(Request $request, $id)
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $pengajuan_sertifikasi = PengajuanSertifikasiModel::find($id);
            if ($pengajuan_sertifikasi) {
                $pengajuan_sertifikasi->delete();
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
    
    public function import()
    {
        return view('pengajuan_sertifikasi.import');
    }
    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_pengajuan_sertifikasi' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $file = $request->file('file_pengajuan_sertifikasi'); // ambil file dari request
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
                            'id_user'                  => $request->input('A'),
                            'id_vendor'                => $request->input('B'),
                            'judul'                    => $request->input('C'),
                            'tujuan'                   => $request->input('D'),
                            'relevansi'                => $request->input('E'),
                            'tanggal'                  => $request->input('F'),
                            'lokasi'                   => $request->input('G'),
                            'biaya'                    => $request->input('H'),
                            'dana'                     => $request->input('I'),
                            'implementasi'             => $request->input('J'),
                            'link'                     => $request->input('K'),
                            'komentar'                 => $request->input('L'),
                            'status'                   => $request->input('M'), 
                            'created_at' => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    PengajuanSertifikasiModel::insertOrIgnore($insert);
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
        $pengajuan_sertifikasi = PengajuanSertifikasiModel::select( 'id_user', 
                                                                    'judul', 
                                                                    'id_vendor',
                                                                    'tujuan',
                                                                    'relevansi',
                                                                    'tanggal',
                                                                    'lokasi',
                                                                    'biaya',
                                                                    'dana',
                                                                    'implementasi',
                                                                    'link',
                                                                    'status',
                                                                    'komentar')
            ->orderBy('id_vendor')
            ->with('vendor')
            ->with('user')
            ->get();
        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama User');
        $sheet->setCellValue('C1', 'Nama Vendor');
        $sheet->setCellValue('D1', 'Judul Sertifikasi');
        $sheet->setCellValue('E1', 'Tujuan');
        $sheet->setCellValue('F1', 'Relevansi dengan Tugas Akademik');
        $sheet->setCellValue('G1', 'Tanggal Pelaksanaan');
        $sheet->setCellValue('H1', 'Lokasi (Online/Offline)');
        $sheet->setCellValue('I1', 'Biaya');
        $sheet->setCellValue('J1', 'Sumber Dana');
        $sheet->setCellValue('K1', 'Rencana Implementasi');
        $sheet->setCellValue('L1', 'Link Informasi Resmi');
        $sheet->setCellValue('K1', 'Status');
        $sheet->setCellValue('N1', 'Komentar Pimjur');

        $sheet->getStyle('A1:N1')->getFont()->setBold(true); // bold header
        $no = 1; // nomor data dimulai dari 1
        $baris = 2; // baris data dimulai dari baris ke 2
        foreach ($pengajuan_sertifikasi as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->user->nama_user);
            $sheet->setCellValue('C' . $baris, $value->vendor->nama_vendor);
            $sheet->setCellValue('D' . $baris, $value->judul); // Judul Sertifikasi
            $sheet->setCellValue('E' . $baris, $value->tujuan);
            $sheet->setCellValue('F' . $baris, $value->relevansi);
            $sheet->setCellValue('G' . $baris, $value->tanggal);
            $sheet->setCellValue('H' . $baris, $value->lokasi);
            $sheet->setCellValue('I' . $baris, $value->biaya);
            $sheet->setCellValue('J' . $baris, $value->dana);
            $sheet->setCellValue('K' . $baris, $value->implementasi);
            $sheet->setCellValue('L' . $baris, $value->link);
            $sheet->setCellValue('M' . $baris, $value->status);
            $sheet->setCellValue('N' . $baris, $value->komentar);
            $baris++;
            $no++;
        }
        foreach (range('A', 'N') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }
        $sheet->setTitle('Data Pengajuan Sertifikasi'); // set title sheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Pengajuan Sertifikasi ' . date('Y-m-d H:i:s') . '.xlsx';
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
        $pengajuan_sertifikasi = PengajuanSertifikasiModel::select('id_user', 
                                                                    'judul', 
                                                                    'id_vendor',
                                                                    'tujuan',
                                                                    'relevansi',
                                                                    'tanggal',
                                                                    'lokasi',
                                                                    'biaya',
                                                                    'dana',
                                                                    'implementasi',
                                                                    'link',
                                                                    'status',
                                                                    'komentar')
            ->orderBy('id_vendor')
            ->orderBy('id_user')
            ->with('vendor')
            ->with('user')
            ->get();
        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('pengajuan_sertifikasi.export_pdf', ['pengajuan_sertifikasi' => $pengajuan_sertifikasi]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url $pdf->render();
        return $pdf->stream('Data pengajuan sertifikasi' . date('Y-m-d H:i:s') . '.pdf');
    }
}
