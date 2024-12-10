<?php
namespace App\Http\Controllers;
use App\Models\BidangMinatModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;

class BidangMinatController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Bidang Minat',
            'list' => ['Home', 'Bidang Minat']
        ];
        $page = (object) [
            'title' => 'Daftar bidang minat yang terdaftar dalam sistem'
        ];
        $activeMenu = 'bidang_minat'; // set menu yang sedang aktif
        $user = UserModel::all(); // ambil data supplier untuk filter user
        return view('bidang_minat.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }
    
    // Ambil data bidang minat dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $bidang_minat = BidangMinatModel::select('id_bidang_minat', 'id_user', 'bidang_minat')
            ->with('user');

        // filter
        if ($request->id_user) {
            $bidang_minat->where('id_user', $request->id_user);
        }
        
        return DataTables::of($bidang_minat)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($bidang_minat) { // menambahkan kolom aksi
                $btn = '<button onclick="modalAction(\'' . url('/bidang_minat/' . $bidang_minat->id_bidang_minat) . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/bidang_minat/' . $bidang_minat->id_bidang_minat . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/bidang_minat/' . $bidang_minat->id_bidang_minat . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    // Menampilkan halaman form tambah bidang minat 
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Bidang Minat',
            'list' => ['Home', 'Bidang Minat', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah Bidang Minat baru'
        ];
        $user = UserModel::all(); // ambil data supplier untuk filter supplier
        $activeMenu = 'bidang_minat'; // set menu yang sedang aktif
        return view('bidang_minat.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan detail bidang minat
    public function store(Request $request)
    {
        $request->validate([
            'id_user'       => 'required|integer',
            'bidang_minat'  => 'required|string|max:50'
        ]);
        BidangMinatModel::create([
            'id_user'       => $request-> id_user,
            'bidang_minat'  => $request-> bidang_minat
        ]);
        return redirect('/bidang_minat')->with('success', 'Data bidang minat berhasil disimpan');
    }

    // Menampilkan detail bidang minat
    public function show(string $id)
    {
        $bidang_minat = BidangMinatModel::with('user')->find($id);
        $breadcrumb = (object) ['title' => 'Detail Bidang Minat', 'list' => ['Home', 'Bidang Minat', 'Detail']];
        $page = (object) ['title' => 'Detail Bidang Minat'];
        $activeMenu = 'bidang_minat'; // set menu yang sedang aktif
        return view('bidang_minat.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'bidang_minat' => $bidang_minat, 'activeMenu' => $activeMenu]);
    }
    // Menampilkan halaman fore edit Bidang Minat 
    public function edit(string $id)
    {
        $bidang_minat = BidangMinatModel::find($id);
        $user = UserModel::all(); // ambil data user untuk filter user
        $breadcrumb = (object) [
            'title' => 'Edit Bidang Minat',
            'list' => ['Home', 'Bidang Minat', 'Edit']
        ];
        $page = (object) [
            "title" => 'Edit Bidang Minat'
        ];
        $activeMenu = 'bidang_minat'; // set menu yang sedang aktif
        return view('bidang_minat.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'bidang_minat'=> $bidang_minat, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan perubahan data bidang minat
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_user'       => 'required|integer',
            'bidang_minat'    => 'required|string|max:50' 
        ]);
        BidangMinatModel::find($id)->update([
            'id_user'       => $request-> id_user,
            'bidang_minat'   => $request-> bidang_minat
        ]);
        return redirect('/bidang_minat')->with("success", "Data bidang minat berhasil diubah");
    }

    // Menghapus data bidang minat 
    public function destroy(string $id)
    {
        $check = BidangMinatModel::find($id);
        if (!$check) {      // untuk mengecek apakah data bidang minat dengan id yang dimaksud ada atau tidak
            return redirect('/bidang_minat')->with('error', 'Data bidang minat tidak ditemukan');
        }
        try {
            BidangMinatModel::destroy($id); // Hapus data supplier
            return redirect('/bidang_minat')->with('success', 'Data bidang minat berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/bidang_minat')->with('error', 'Data bidang minat gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    // 1. public function create_ajax()
    public function create_ajax()
    {
        $user = UserModel::select('id_user', 'nama_user')->get();
        return view('bidang_minat.create_ajax')
            ->with('user', $user);
    }
    

    // 2. public function store_ajax(Request $request)
    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_user'       => 'required|integer',
                'bidang_minat'    => 'required|string|max:50' 
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
            BidangMinatModel::create($request->all());
            return response()->json([
                'status'    => true,
                'message'   => 'Data user berhasil disimpan'
            ]);
        }
        redirect('/');
    }


    // 3. public function edit_ajax(string $id)
    public function edit_ajax(string $id)
    {
        $bidang_minat = BidangMinatModel::find($id);
        $user = UserModel::select('id_user', 'nama_user')->get();

        return view('bidang_minat.edit_ajax', ['bidang_minat' => $bidang_minat, 'user' => $user]);
    }

    // 4. public function update_ajax(Request $request, $id)
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_user'       => 'required|integer',
                'bidang_minat'    => 'required|string|max:50' 
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
            $check = BidangMinatModel::find($id);
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
        $bidang_minat = BidangMinatModel::find($id);
        return view('bidang_minat.confirm_ajax', ['bidang_minat' => $bidang_minat]);
    }

    // 6. public function delete_ajax(Request $request, $id)
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $bidang_minat = BidangMinatModel::find($id);
            if ($bidang_minat) {
                $bidang_minat->delete();
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
        $bidang_minat = BidangMinatModel::find($id);
        $user = UserModel::find($bidang_minat->id_user);

        return view('bidang_minat.show_ajax', ['bidang_minat' => $bidang_minat, 'user' => $user]);
    }

    
    public function import()
    {
        return view('bidang_minat.import');
    }
    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_bidang_minat' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $file = $request->file('file_bidang_minat'); // ambil file dari request
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
                            'bidang_minat'  => $value['B'],
                            'created_at' => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    BidangMinatModel::insertOrIgnore($insert);
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
        $bidang_minat = BidangMinatModel::select('id_user', 'bidang_minat')
            ->orderBy('id_user')
            ->with('user')
            ->get();
        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama User');
        $sheet->setCellValue('C1', 'Bidang Minat');
        $sheet->getStyle('A1:C1')->getFont()->setBold(true); // bold header
        $no = 1; // nomor data dimulai dari 1
        $baris = 2; // baris data dimulai dari baris ke 2
        foreach ($bidang_minat as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->user->nama_user);
            $sheet->setCellValue('C' . $baris, $value->bidang_minat);
            $baris++;
            $no++;
        }
        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }
        $sheet->setTitle('Data Bidang Minat'); // set title sheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Bidang Minat ' . date('Y-m-d H:i:s') . '.xlsx';
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
        $bidang_minat = BidangMinatModel::select('id_user', 'bidang_minat')
            ->orderBy('id_user')
            ->with('user')
            ->get();
        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('bidang_minat.export_pdf', ['bidang_minat' => $bidang_minat]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url $pdf->render();
        return $pdf->stream('Data bidang minat' . date('Y-m-d H:i:s') . '.pdf');
    }
}
