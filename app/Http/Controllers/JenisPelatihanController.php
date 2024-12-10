<?php
namespace App\Http\Controllers;

use App\Models\JenisPelatihanModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\IOFactory;

class JenisPelatihanController extends Controller
{
    // Menampilkan halaman awal Jenis Pelatihan
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Jenis Pelatihan',
            'list'  => ['Home', 'Jenis Pelatihan']
        ];

        $page = (object) [
            'title' => 'Daftar Jenis Pelatihan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'jenis_pelatihan'; // set menu yang sedang aktif

        return view('jenis_pelatihan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Ambil data Jenis Pelatihan dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $jenis_pelatihan = JenisPelatihanModel::select('id_jenpel', 'nama_jenpel');

        // Return data untuk DataTables
        return DataTables::of($jenis_pelatihan)
            ->addIndexColumn() // menambahkan kolom index / nomor urut
            ->addColumn('aksi', function ($jenis_pelatihan) {
           
                $btn = '<button onclick="modalAction(\'' . url('/jenis_pelatihan/' . $jenis_pelatihan->id_jenpel ) . '\')" class="btn btn-info btn-sm">Detail</a>';
                $btn .= '<button onclick="modalAction(\'' . url('/jenis_pelatihan/' . $jenis_pelatihan->id_jenpel . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/jenis_pelatihan/' . $jenis_pelatihan->id_jenpel . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi berisi HTML
            ->make(true);
    }

    // Menampilkan halaman form tambah Jenis Pelatihan
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Jenis Pelatihan',
            'list'  => ['Home', 'Jenis Pelatihan', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Jenis Pelatihan baru'
        ];

        $activeMenu = 'jenis_pelatihan'; // set menu yang sedang aktif

        return view('jenis_pelatihan.create', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'activeMenu' => $activeMenu
        ]);
    }
    
    // Menyimpan data Jenis Pelatihan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_jenpel' => 'required|string|max:100', // nama harus diisi, berupa string, maksimal 100 karakter
        ]);

        JenisPelatihanModel::create([
            'nama_jenpel' => $request->nama_jenpel
        ]);

        return redirect('/jenis_pelatihan')->with('success', 'Data Jenis Pelatihan berhasil disimpan');
    }

    // Menampilkan detail Jenis Pelatihan
    public function show(string $id)
    {
        $jenis_pelatihan = JenisPelatihanModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Jenis Pelatihan',
            'list'  => ['Home', 'Jenis Pelatihan', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Jenis Pelatihan'
        ];

        $activeMenu = 'jenis_pelatihan'; // set menu yang sedang aktif

        return view('jenis_pelatihan.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'jenis_pelatihan' => $jenis_pelatihan, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit Jenis Pelatihan
    public function edit(string $id)
    {
        $jenis_pelatihan = JenisPelatihanModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Jenis Pelatihan',
            'list'  => ['Home', 'Jenis Pelatihan', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Jenis Pelatihan'
        ];

        $activeMenu = 'jenis_pelatihan'; // set menu yang sedang aktif

        return view('jenis_pelatihan.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'jenis_pelatihan' => $jenis_pelatihan, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan perubahan data Jenis Pelatihan
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_jenpel' => 'required|string|max:100'
        ]);

        JenisPelatihanModel::find($id)->update([
            'nama_jenpel' => $request->nama_jenpel,
        ]);

        return redirect('/jenis_pelatihan')->with('success', 'Data Jenis Pelatihan berhasil diubah');
    }

    // Menghapus data Jenis Pelatihan
    public function destroy(string $id)
    {
        $check = JenisPelatihanModel::find($id);
        if (!$check) {  // untuk mengecek apakah data Jenis Pelatihan dengan id yang dimaksud ada atau tidak
            return redirect('/jenis_pelatihan')->with('error', 'Data Jenis Pelatihan tidak ditemukan');
        }

        try {
            JenisPelatihanModel::destroy($id);  // Hapus data Jenis Pelatihan

            return redirect('/jenis_pelatihan')->with('success', 'Data Jenis Pelatihan berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/jenis_pelatihan')->with('error', 'Data Jenis Pelatihan gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function show_ajax(string $id) {
        $jenis_pelatihan = JenisPelatihanModel::find($id);

        return view('jenis_pelatihan.show_ajax', ['jenis_pelatihan' => $jenis_pelatihan]);
    }

    // 1. public function create_ajax()
    public function create_ajax()
    {
        return view('jenis_pelatihan.create_ajax');
    }

    // 2. public function store_ajax(Request $request)
    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_jenpel' => 'required|string|max:100'
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
            JenisPelatihanModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data Jenis Pelatihan berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    // 3. public function edit_ajax(string $id)
    public function edit_ajax(string $id)
    {
        $jenis_pelatihan = JenisPelatihanModel::find($id);
        return view('jenis_pelatihan.edit_ajax', ['jenis_pelatihan' => $jenis_pelatihan]);
    }

    // 4. public function update_ajax(Request $request, $id)
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_jenpel' => 'required|max:100'
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
            $check = JenisPelatihanModel::find($id);
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
        $jenis_pelatihan = JenisPelatihanModel::find($id);
        return view('jenis_pelatihan.confirm_ajax', ['jenis_pelatihan' => $jenis_pelatihan]);
    }

    // 6. public function delete_ajax(Request $request, $id)
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $jenis_pelatihan = JenisPelatihanModel::find($id);
            if ($jenis_pelatihan) {
                $jenis_pelatihan->delete();
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
        return view('jenis_pelatihan.import');
    }
    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_jenis_pelatihan' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $file = $request->file('file_jenis_pelatihan'); // ambil file dari request
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
                            'nama_jenpel' => $value['A'],
                            'created_at' => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    JenisPelatihanModel::insertOrIgnore($insert);
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
        // ambil data Jenis Pelatihan yang akan di export
        $jenis_pelatihan = JenisPelatihanModel::select('nama_jenpel')
            ->orderBy('nama_jenpel')
            ->get();
        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Jenis Pelatihan');
        $sheet->getStyle('A1:B1')->getFont()->setBold(true); // bold header
        $no = 1; // nomor data dimulai dari 1
        $baris = 2; // baris data dimulai dari baris ke 2
        foreach ($jenis_pelatihan as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->nama_jenpel);
            $baris++;
            $no++;
        }
        foreach (range('A', 'B') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }
        $sheet->setTitle('Data Jenis Pelatihan'); // set title sheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Jenis Pelatihan ' . date('Y-m-d H:i:s') . '.xlsx';
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
        $jenis_pelatihan = JenisPelatihanModel::select('nama_jenpel')
            ->orderBy('nama_jenpel')
            ->get();
        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('jenis_pelatihan.export_pdf', ['jenis_pelatihan' => $jenis_pelatihan]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url $pdf->render();
        return $pdf->stream('Data Jenis Pelatihan' . date('Y-m-d H:i:s') . '.pdf');
    }

}