@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($vendor)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID</th>
                        <td>{{ $vendor->id_vendor }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $vendor->nama_vendor }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $vendor->alamat_vendor }}</td>
                    </tr>
                    <tr>
                        <th>No. Telepon</th>
                        <td>{{ $vendor->telp_vendor }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Vendor</th>
                        <td>{{ $vendor->jenis_vendor }}</td>
                    </tr>
                </table>
            @endempty
            <a href="{{ url('vendor') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        </div>
    </div>
@endsection
