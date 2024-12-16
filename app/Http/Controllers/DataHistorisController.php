<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LevelModel;
use App\Models\SertifikasiModel;
use App\Models\UserModel;
use App\Models\PelatihanModel;
use Illuminate\Support\Facades\Validator;

class DataHistorisController extends Controller
{
    public function index()
    {
        // Mengambil ID pengguna yang sedang login
        $id = session('id_user');

        // Menyiapkan breadcrumb untuk tampilan
        $breadcrumb = (object) [
            'title' => 'Data Historis',
            'list' => ['Home', 'Data Historis']
        ];

        $page = (object) [
            'title' => 'Data Historis Anda'
        ];

        // Menandai menu yang sedang aktif
        $activeMenu = 'data_historis';

        // Mengambil data pengguna beserta levelnya berdasarkan ID pengguna yang sedang login
        $user = UserModel::with('level')->find($id);

        // Mengambil data sertifikasi (bisa dipakai untuk filter jika perlu)
        $sertifikasi = SertifikasiModel::where('id_user', $id)->get();

        // Mengambil data pelatihan berdasarkan user_id yang sedang login
        $pelatihan = PelatihanModel::where('id_user', $id)->get();

        // Menggabungkan data dari pelatihan dan sertifikasi
        // Anda bisa menggunakan merge() untuk menggabungkan dua koleksi
        $dataHistoris = $pelatihan->merge($sertifikasi);

        // Menyusun data berdasarkan tanggal (misalnya berdasarkan tgl_mulai untuk pelatihan dan tgl_mulai_sertif untuk sertifikasi)
        $dataHistoris = $dataHistoris->sortByDesc(function ($item) {
            return $item->tgl_mulai ?? $item->tgl_mulai_sertif;  // Menyortir berdasarkan tanggal yang ada
        });

        // Mengambil data level untuk filter level
        $level = LevelModel::all();

        // Menampilkan view dengan data historis yang sudah digabungkan
        return view('data_historis.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'user' => $user,
            'sertifikasi' => $sertifikasi,
            'pelatihan' => $pelatihan,
            'activeMenu' => $activeMenu,
            'dataHistoris' => $dataHistoris // Menambahkan data historis yang sudah digabungkan
        ]);
    }

    public function show(string $id)
    {
        $sertifikasi = SertifikasiModel::all();
        $pelatihan = PelatihanModel::all();
        $user = UserModel::with('level')->find($id);

        $breadcrumb = (object) ['title' => 'Detail User', 'list' => ['Home', 'User', 'Detail']];
        $page = (object) ['title' => 'Detail user'];
        $activeMenu = 'user'; // set menu yang sedang aktif

        return view('user.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'sertifikasi' => $sertifikasi,
            'pelatihan' => $pelatihan,
            'activeMenu' => $activeMenu
        ]);
    }
}
