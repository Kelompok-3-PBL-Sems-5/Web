<?php

namespace App\Http\Controllers;

use App\Models\PeriodeModel;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\PeriodeExport;
use App\Imports\PeriodeImport;
use App\Models\SertifikasiModel;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Storage;

class PeriodeController extends Controller
{
    public function index()
    {
        $sertifikasi = SertifikasiModel::all();
        $user = User::all();
        return view('periode.index', compact('sertifikasi', 'user'));
    }

    public function list(Request $request)
    {
        $data = PeriodeModel::with(['sertifikasi', 'user']);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $btn = '<div class="btn-group" role="group">';
                $btn .= '<button onclick="modalAction(\'' . url("periode/$row->id_periode") . '\')" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></button>';
                $btn .= '<button onclick="modalAction(\'' . url("periode/$row->id_periode/edit_ajax") . '\')" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button>';
                $btn .= '<button onclick="modalAction(\'' . url("periode/$row->id_periode/delete_ajax") . '\')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                $btn .= '</div>';
                return $btn;
            })
            ->editColumn('id_user', function ($row) {
                return $row->user ? $row->user->nama_user : '-';
            })
            ->editColumn('id_sertifikasi', function ($row) {
                return $row->sertifikasi ? $row->sertifikasi->nama_sertif : '-';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at ? Carbon::parse($row->created_at)->format('d/m/Y H:i:s') : '';
            })
            ->editColumn('updated_at', function ($row) {
                return $row->updated_at ? Carbon::parse($row->updated_at)->format('d/m/Y H:i:s') : '';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        $sertifikasi = SertifikasiModel::all();
        $user = User::all();
        return view('periode.create_ajax', compact('sertifikasi', 'user'));
    }

    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_sertifikasi' => 'required|exists:t_sertifikasi,id_sertifikasi',
            'id_user' => 'required|exists:users,id_user',
            'status' => 'required|in:Aktif,Tidak Aktif'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'msgField' => $validator->errors()
            ]);
        }

        try {
            PeriodeModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data periode berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan data periode'
            ]);
        }
    }

    public function show($id)
    {
        $periode = PeriodeModel::with(['sertifikasi', 'user'])->find($id);
        return view('periode.show', compact('periode'));
    }

    public function edit_ajax($id)
    {
        $periode = PeriodeModel::find($id);
        $sertifikasi = SertifikasiModel::all();
        $user = User::all();
        return view('periode.edit_ajax', compact('periode', 'sertifikasi', 'user'));
    }

    public function update_ajax(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_sertifikasi' => 'required|exists:t_sertifikasi,id_sertifikasi',
            'id_user' => 'required|exists:users,id_user',
            'status' => 'required|in:Aktif,Tidak Aktif'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'msgField' => $validator->errors()
            ]);
        }

        try {
            $periode = PeriodeModel::find($id);
            $periode->update($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data periode berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui data periode'
            ]);
        }
    }

    public function confirm_ajax($id)
    {
        $periode = PeriodeModel::with(['sertifikasi', 'user'])->find($id);
        return view('periode.confirm_ajax', compact('periode'));
    }

    public function delete_ajax($id)
    {
        try {
            $periode = PeriodeModel::find($id);
            $periode->delete();
            return response()->json([
                'status' => true,
                'message' => 'Data periode berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data periode'
            ]);
        }
    }

    public function import()
    {
        return view('periode.import');
    }

    public function import_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_periode' => 'required|mimes:xlsx,xls'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'msgField' => $validator->errors()
            ]);
        }

        try {
            $importer = new PeriodeImport();
            $result = $importer->import($request->file('file_periode'));
            
            $message = "Berhasil import {$result['successful']} data.";
            if ($result['failed'] > 0) {
                $message .= " Gagal import {$result['failed']} data.";
            }

            return response()->json([
                'status' => true,
                'message' => $message,
                'errors' => $result['errors']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengimport data periode: ' . $e->getMessage()
            ]);
        }
    }

    public function export_excel()
    {
        try {
            $exporter = new PeriodeExport();
            $filepath = $exporter->export();
            
            return response()->download($filepath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengexport data: ' . $e->getMessage());
        }
    }
}