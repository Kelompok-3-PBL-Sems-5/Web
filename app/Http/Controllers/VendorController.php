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

        // Ambil semua data vendor dari database
        $vendor = VendorModel::all();

        return view('vendor.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'vendor' => $vendor]);
    }

    // Ambil data vendor dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $filterVendor = $request->input('filter_vendor');
        $vendor = VendorModel::select('id_vendor', 'nama_vendor', 'alamat_vendor', 'jenis_vendor', 'telp_vendor', 'alamat_web');

        // Tambahkan filter jika ada
        if ($filterVendor) {
            $vendor->where('jenis_vendor', $filterVendor);
        }

        // Return data untuk DataTables
        return DataTables::of($vendor)
            ->addIndexColumn()
            ->addColumn('aksi', function ($vendor) {
                $btn = '<a href="' . url('/vendor/' . $vendor->id_vendor) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<button onclick="modalAction(\'' . url('/vendor/' . $vendor->id_vendor . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/vendor/' . $vendor->id_vendor . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
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
                'jenis_vendor'    => 'required|string|max:50', // Jenis vendor harus diisi
                'telp_vendor'     => 'nullable|string|max:20', // Telepon vendor bersifat opsional
                'alamat_web'      => 'required|string', // Alamat web harus diisi
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
                'jenis_vendor'  => 'required|string|max:50', // Jenis vendor harus diisi
                'telp_vendor'   => 'nullable|string|max:20', // Telepon vendor bersifat opsional
                'alamat_web'      => 'required|string', // Alamat web harus diisi
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
    
    public function import_ajax(Request $request)
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
                            'jenis_vendor'  => $value['C'], // Kolom C untuk jenis vendor
                            'telp_vendor'   => $value['D'], // Kolom D untuk telepon vendor
                            'alamat_web' => $value['E'], // Kolom E untuk alamat web
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
    
    public function export_excel()
    {
        // ambil data vendor yang akan di export
        $vendor = VendorModel::select('nama_vendor', 'alamat_vendor', 'jenis_vendor', 'telp_vendor', 'alamat_web')
            ->orderBy('nama_vendor')
            ->get();
        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Vendor');
        $sheet->setCellValue('C1', 'Alamat Vendor');
        $sheet->setCellValue('D1', 'Jenis Vendor');
        $sheet->setCellValue('E1', 'Telepon Vendor');
        $sheet->setCellValue('F1', 'Alamat Web');
        $sheet->getStyle('A1:F1')->getFont()->setBold(true); // bold header
        $no = 1; // nomor data dimulai dari 1
        $baris = 2; // baris data dimulai dari baris ke 2
        foreach ($vendor as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->nama_vendor);
            $sheet->setCellValue('C' . $baris, $value->alamat_vendor);
            $sheet->setCellValue('D' . $baris, $value->jenis_vendor);
            $sheet->setCellValue('E' . $baris, $value->telp_vendor);
            $sheet->setCellValue('F' . $baris, $value->alamat_web);
            $baris++;
            $no++;
        }
        foreach (range('A', 'F') as $columnID) {
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
    } // end function export_excel
    public function export_pdf()
    {
        $vendor = VendorModel::select('nama_vendor', 'alamat_vendor', 'jenis_vendor', 'telp_vendor', 'alamat_web')
            ->orderBy('nama_vendor')
            ->get();
        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('vendor.export_pdf', ['vendor' => $vendor]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url $pdf->render();
        return $pdf->stream('Data vendor' . date('Y-m-d H:i:s') . '.pdf');
    }
}
