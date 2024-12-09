<?php
namespace App\Http\Controllers;

use App\Models\kompetensiModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\IOFactory;

class kompetensiController extends Controller
{
    // Menampilkan halaman awal kompetensi
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar kompetensi',
            'list'  => ['Home', 'kompetensi']
        ];

        $page = (object) [
            'title' => 'Daftar kompetensi yang terdaftar dalam sistem'
        ];

        $activeMenu = 'kompetensi'; // set menu yang sedang aktif

        return view('kompetensi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Ambil data kompetensi dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        // Ambil data kompetensi
        $kompetensi = kompetensiModel::select('id_kompetensi', 'nama_kompetensi', 'id_user');

        // Return data untuk DataTables
        return DataTables::of($kompetensi)
            ->addIndexColumn() // menambahkan kolom index / nomor urut
            ->addColumn('aksi', function ($kompetensi) {
                // Menambahkan kolom aksi untuk edit, detail, dan hapus
                // $btn = '<a href="' . url('/kompetensi/' . $kompetensi->id_kompetensi) . '" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="' . url('/kompetensi/' . $kompetensi->id_kompetensi . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/kompetensi/' . $kompetensi->id_kompetensi) . '">'
                //     . csrf_field() . method_field('DELETE') .
                //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                // return $btn;

                $btn = '<a href="' . url('/kompetensi/' . $kompetensi->id_kompetensi) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kompetensi/' . $kompetensi->id_kompetensi . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kompetensi/' . $kompetensi->id_kompetensi . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi berisi HTML
            ->make(true);
    }

    // Menampilkan halaman form tambah kompetensi
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah kompetensi',
            'list'  => ['Home', 'kompetensi', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah kompetensi baru'
        ];

        $activeMenu = 'kompetensi'; // set menu yang sedang aktif

        return view('kompetensi.create', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan data kompetensi baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_kompetensi' => 'required|string|max:100', // Nama kompetensi harus diisi, berupa string, dan maksimal 100 karakter
            'id_user' => 'nullable|integer'
        ]);

        kompetensiModel::create([
            'nama_kompetensi' => $request->nama_kompetensi,
            'id_user' => $request->id_user
        ]);

        return redirect('/kompetensi')->with('success', 'Data kompetensi berhasil disimpan');
    }

    // Menampilkan detail kompetensi
    public function show(string $id)
    {
        $kompetensi = kompetensiModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail kompetensi',
            'list'  => ['Home', 'kompetensi', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail kompetensi'
        ];

        $activeMenu = 'kompetensi'; // set menu yang sedang aktif

        return view('kompetensi.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kompetensi' => $kompetensi, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit kompetensi
    public function edit(string $id)
    {
        $kompetensi = kompetensiModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit kompetensi',
            'list'  => ['Home', 'kompetensi', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit kompetensi'
        ];

        $activeMenu = 'kompetensi'; // set menu yang sedang aktif

        return view('kompetensi.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kompetensi' => $kompetensi, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan perubahan data kompetensi
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kompetensi' => 'required|string|max:100', // Nama kompetensi harus diisi
            'id_user' => 'nullable|integer'
        ]);

        kompetensiModel::find($id)->update([
            'nama_kompetensi' => $request->nama_kompetensi,
            'id_user' => $request->id_user
        ]);

        return redirect('/kompetensi')->with('success', 'Data kompetensi berhasil diubah');
    }

    // Menghapus data kompetensi
    public function destroy(string $id)
    {
        $check = kompetensiModel::find($id);
        if (!$check) {  
            return redirect('/kompetensi')->with('error', 'Data kompetensi tidak ditemukan');
        }

        try {
            kompetensiModel::destroy($id); 

            return redirect('/kompetensi')->with('success', 'Data kompetensi berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/kompetensi')->with('error', 'Data kompetensi gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    // 1. public function create_ajax()
    public function create_ajax()
    {
        return view('kompetensi.create_ajax');
    }

    // 2. public function store_ajax(Request $request)
    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_kompetensi' => 'required|string|max:100'
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
            kompetensiModel::create($request->all());
            return response()->json([
                'status'    => true,
                'message'   => 'Data kompetensi berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    // 3. public function edit_ajax(string $id)
    public function edit_ajax(string $id)
    {
        $kompetensi = kompetensiModel::find($id);
        return view('kompetensi.edit_ajax', ['kompetensi' => $kompetensi]);
    }

    // 4. public function update_ajax(Request $request, $id)
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_kompetensi' => 'required|string|max:100'
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
            $check = kompetensiModel::find($id);
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
        $kompetensi = kompetensiModel::find($id);
        return view('kompetensi.confirm_ajax', ['kompetensi' => $kompetensi]);
    }

    // 6. public function delete_ajax(Request $request, $id)
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $kompetensi = kompetensiModel::find($id);
            if ($kompetensi) {
                $kompetensi->delete();
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
        return view('kompetensi.import');
    }
    
    /* public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_kompetensi' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $file = $request->file('file_kompetensi'); // ambil file dari request
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
                            'nama_kompetensi'   => $value['A'], // Kolom A untuk nama kompetensi
                            'alamat_kompetensi' => $value['B'], // Kolom B untuk alamat kompetensi
                            'telp_kompetensi'   => $value['C'], // Kolom C untuk telepon kompetensi
                            'jenis_kompetensi'  => $value['D'], // Kolom D untuk jenis kompetensi
                            'created_at' => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    kompetensiModel::insertOrIgnore($insert);
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
        // ambil data kompetensi yang akan di export
        $kompetensi = kompetensiModel::select('nama_kompetensi', 'alamat_kompetensi', 'telp_kompetensi', 'jenis_kompetensi')
            ->orderBy('nama_kompetensi')
            ->get();
        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama kompetensi');
        $sheet->setCellValue('C1', 'Alamat kompetensi');
        $sheet->setCellValue('D1', 'Telepon kompetensi');
        $sheet->setCellValue('E1', 'Jenis kompetensi');
        $sheet->getStyle('A1:E1')->getFont()->setBold(true); // bold header
        $no = 1; // nomor data dimulai dari 1
        $baris = 2; // baris data dimulai dari baris ke 2
        foreach ($kompetensi as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->nama_kompetensi);
            $sheet->setCellValue('C' . $baris, $value->alamat_kompetensi);
            $sheet->setCellValue('D' . $baris, $value->telp_kompetensi);
            $sheet->setCellValue('E' . $baris, $value->jenis_kompetensi);
            $baris++;
            $no++;
        }
        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }
        $sheet->setTitle('Data kompetensi'); // set title sheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data kompetensi ' . date('Y-m-d H:i:s') . '.xlsx';
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
        $kompetensi = kompetensiModel::select('nama_kompetensi', 'alamat_kompetensi', 'telp_kompetensi', 'jenis_kompetensi')
            ->orderBy('nama_kompetensi')
            ->get();
        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('kompetensi.export_pdf', ['kompetensi' => $kompetensi]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url $pdf->render();
        return $pdf->stream('Data kompetensi' . date('Y-m-d H:i:s') . '.pdf');
    }
}