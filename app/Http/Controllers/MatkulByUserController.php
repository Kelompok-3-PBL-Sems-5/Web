<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\MatKulModel;
use Illuminate\Support\Facades\Auth;
use App\Models\UserModel;

class MatkulByUserController extends Controller
{
    public function index()
    {
        // Ambil id_user dari session
        $id = session('id_user');

        // Redirect jika id_user tidak ada di session
        if (!$id) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Breadcrumb dan metadata halaman
        $breadcrumb = (object) [
            'title' => 'Mata Kuliah',
            'list' => ['Home', 'Mata Kuliah']
        ];

        $page = (object) [
            'title' => 'Mata Kuliah Anda'
        ];

        $activeMenu = 'matkul';

        // Ambil data user dan validasi keberadaannya
        $user = UserModel::with('level')->find($id);
        if (!$user) {
            return redirect()->route('login')->with('error', 'Data user tidak ditemukan.');
        }

        // Ambil data mata kuliah berdasarkan user
        $matkul = MatKulModel::where('id_user', $id)->get();

        // Ambil semua data level (opsional)
        $level = LevelModel::all();

        // Return ke view dengan data
        return view('matkul.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'user' => $user,
            'matkul' => $matkul,
            'activeMenu' => $activeMenu
        ]);
    }
}
