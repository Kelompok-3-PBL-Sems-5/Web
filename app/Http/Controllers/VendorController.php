<?php
namespace App\Http\Controllers;

use App\Models\VendorModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\IOFactory;

class VendorController extends Controller
{
    // Menampilkan halaman awal vendor
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Vendor',
            'list'  => ['Home', 'Vendor']
        ];

        $page = (object) [
            'title' => 'Daftar vendor yang terdaftar dalam sistem'
        ];

        $activeMenu = 'vendor'; // set menu yang sedang aktif

        return view('vendor.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Ambil data vendor dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        // Ambil data vendor
        $vendor = VendorModel::select('id_vendor', 'nama_vendor', 'alamat_vendor', 'telp_vendor', 'jenis_vendor');

        // Return data untuk DataTables
        return DataTables::of($vendor)
            ->addIndexColumn() // menambahkan kolom index / nomor urut
            ->addColumn('aksi', function ($vendor) {
                // Menambahkan kolom aksi untuk edit, detail, dan hapus
                // $btn = '<a href="' . url('/vendor/' . $vendor->id_vendor) . '" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="' . url('/vendor/' . $vendor->id_vendor . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/vendor/' . $vendor->id_vendor) . '">'
                //     . csrf_field() . method_field('DELETE') .
                //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                // return $btn;

                $btn = '<a href="' . url('/vendor/' . $vendor->id_vendor) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<button onclick="modalAction(\'' . url('/vendor/' . $vendor->id_vendor . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/vendor/' . $vendor->id_vendor . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi berisi HTML
            ->make(true);
    }

    // Menampilkan halaman form tambah vendor
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Vendor',
            'list'  => ['Home', 'Vendor', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah vendor baru'
        ];

        $activeMenu = 'vendor'; // set menu yang sedang aktif

        return view('vendor.create', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan data vendor baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_vendor' => 'required|string|max:100', // Nama vendor harus diisi, berupa string, dan maksimal 100 karakter
            'alamat_vendor' => 'required|string|max:255', // Alamat vendor harus diisi, maksimal 255 karakter
            'telp_vendor' => 'required|string|max:15', // Nomor telepon vendor harus diisi dan maksimal 15 karakter
            'jenis_vendor' => 'required|string|max:50', // Jenis vendor harus diisi, berupa string, dan maksimal 50 karakter
        ]);

        VendorModel::create([
            'nama_vendor' => $request->nama_vendor,
            'alamat_vendor' => $request->alamat_vendor,
            'telp_vendor' => $request->telp_vendor,
            'jenis_vendor' => $request->jenis_vendor,
        ]);

        return redirect('/vendor')->with('success', 'Data vendor berhasil disimpan');
    }

    // Menampilkan detail vendor
    public function show(string $id)
    {
        $vendor = VendorModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Vendor',
            'list'  => ['Home', 'Vendor', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail vendor'
        ];

        $activeMenu = 'vendor'; // set menu yang sedang aktif

        return view('vendor.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'vendor' => $vendor, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit vendor
    public function edit(string $id)
    {
        $vendor = VendorModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Vendor',
            'list'  => ['Home', 'Vendor', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit vendor'
        ];

        $activeMenu = 'vendor'; // set menu yang sedang aktif

        return view('vendor.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'vendor' => $vendor, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan perubahan data vendor
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_vendor' => 'required|string|max:100', // Nama vendor harus diisi
            'alamat_vendor' => 'required|string|max:255', // Alamat vendor harus diisi
            'telp_vendor' => 'required|string|max:15', // Telepon vendor harus diisi
            'jenis_vendor' => 'required|string|max:50', // Jenis vendor harus diisi
        ]);

        VendorModel::find($id)->update([
            'nama_vendor' => $request->nama_vendor,
            'alamat_vendor' => $request->alamat_vendor,
            'telp_vendor' => $request->telp_vendor,
            'jenis_vendor' => $request->jenis_vendor,
        ]);

        return redirect('/vendor')->with('success', 'Data vendor berhasil diubah');
    }

    // Menghapus data vendor
    public function destroy(string $id)
    {
        $check = VendorModel::find($id);
        if (!$check) {  
            return redirect('/vendor')->with('error', 'Data vendor tidak ditemukan');
        }

        try {
            VendorModel::destroy($id); 

            return redirect('/vendor')->with('success', 'Data vendor berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/vendor')->with('error', 'Data vendor gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    // 1. public function create_ajax()
    public function create_ajax()
    {
        return view('vendor.create_ajax');
    }

    // 2. public function store_ajax(Request $request)
    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_vendor'     => 'required|string|max:100', // Nama vendor harus diisi
                'alamat_vendor'   => 'required|string|max:100', // Alamat vendor harus diisi
                'telp_vendor'     => 'nullable|string|max:20', // Telepon vendor bersifat opsional
                'jenis_vendor'    => 'required|string|max:50', // Jenis vendor harus diisi
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
            VendorModel::create($request->all());
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
        $vendor = VendorModel::find($id);
        return view('vendor.edit_ajax', ['vendor' => $vendor]);
    }

    // 4. public function update_ajax(Request $request, $id)
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_vendor'   => 'required|string|max:100', // Nama vendor harus diisi
                'alamat_vendor' => 'required|string|max:100', // Alamat vendor harus diisi
                'telp_vendor'   => 'nullable|string|max:20', // Telepon vendor bersifat opsional
                'jenis_vendor'  => 'required|string|max:50', // Jenis vendor harus diisi
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
            $check = VendorModel::find($id);
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
        $vendor = VendorModel::find($id);
        return view('vendor.confirm_ajax', ['vendor' => $vendor]);
    }

    // 6. public function delete_ajax(Request $request, $id)
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $vendor = VendorModel::find($id);
            if ($vendor) {
                $vendor->delete();
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
        return view('vendor.import');
    }
    
    /* public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_vendor' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $file = $request->file('file_vendor'); // ambil file dari request
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
                            'nama_vendor'   => $value['A'], // Kolom A untuk nama vendor
                            'alamat_vendor' => $value['B'], // Kolom B untuk alamat vendor
                            'telp_vendor'   => $value['C'], // Kolom C untuk telepon vendor
                            'jenis_vendor'  => $value['D'], // Kolom D untuk jenis vendor
                            'created_at' => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    VendorModel::insertOrIgnore($insert);
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
        // ambil data vendor yang akan di export
        $vendor = VendorModel::select('nama_vendor', 'alamat_vendor', 'telp_vendor', 'jenis_vendor')
            ->orderBy('nama_vendor')
            ->get();
        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Vendor');
        $sheet->setCellValue('C1', 'Alamat Vendor');
        $sheet->setCellValue('D1', 'Telepon Vendor');
        $sheet->setCellValue('E1', 'Jenis Vendor');
        $sheet->getStyle('A1:E1')->getFont()->setBold(true); // bold header
        $no = 1; // nomor data dimulai dari 1
        $baris = 2; // baris data dimulai dari baris ke 2
        foreach ($vendor as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->nama_vendor);
            $sheet->setCellValue('C' . $baris, $value->alamat_vendor);
            $sheet->setCellValue('D' . $baris, $value->telp_vendor);
            $sheet->setCellValue('E' . $baris, $value->jenis_vendor);
            $baris++;
            $no++;
        }
        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }
        $sheet->setTitle('Data vendor'); // set title sheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data vendor ' . date('Y-m-d H:i:s') . '.xlsx';
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
        $vendor = VendorModel::select('nama_vendor', 'alamat_vendor', 'telp_vendor', 'jenis_vendor')
            ->orderBy('nama_vendor')
            ->get();
        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('vendor.export_pdf', ['vendor' => $vendor]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url $pdf->render();
        return $pdf->stream('Data vendor' . date('Y-m-d H:i:s') . '.pdf');
    }
}
