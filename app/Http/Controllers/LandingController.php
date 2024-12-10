<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('landing.index');
    }

    // public function details()
    // {
    //     return view('landing.details');
    // }

    // public function halaman_dosen()
    // {
    //     return view('landing.halaman_dosen');
    // }

    // public function d_sertifikasi()
    // {
    //     return view('landing.d_sertifikasi');
    // }

    // public function d_pelatihan()
    // {
    //     return view('landing.d_pelatihan');
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
