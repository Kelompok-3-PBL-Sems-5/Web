@extends('layouts.template')

@section('content')
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
    data-keyboard="false" data-width="75%" aria-hidden="true"></div>

<div class="container rounded bg-white profile-container"> <!-- Ganti class border dengan profile-container -->
    <div class="row" id="profile">
        <div class="col-md-4 border-right">
            <div class="p-3 py-5">
                <div class="d-flex flex-column align-items-center text-center p-3">
                    <img class="rounded-circle mt-3 mb-2" width="250px" src="{{ asset($user->foto) }}">
                    <p class="photo-date">Foto diganti pada: {{ $user->updated_at->format('d-m-Y') }}</p>
                </div>
                <div onclick="modalAction('{{ url('/profile/' . session('id_user') . '/edit_foto') }}')"
                    class="mt-4 text-center">
                    <button class="btn btn-primary profile-button" type="button">Edit Foto</button>
                </div>
            </div>
        </div>
        <div class="col-md-8 border-right">
            <div class="p-3 py-4">
                <div class="d-flex align-items-center">
                    <h4 class="profile-header">Pengaturan Profile</h4>
                </div>
                <div class="row mt-3">
                    <table class="table table-bordered table-striped table-hover table-sm">
                        <tr>
                            <th>ID</th>
                            <td>{{ $user->id_user }}</td>
                        </tr>
                        <tr>
                            <th>Level</th>
                            <td>{{ $user->level->nama_level }}</td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td>{{ $user->username }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $user->nama_user }}</td>
                        </tr>
                        <tr>
                            <th>Password</th>
                            <td>********</td>
                        </tr>
                    </table>
                </div>
                <div class="mt-3 text-center">
                    <button onclick="modalAction('{{ url('/profile/' . session('id_user') . '/edit_ajax') }}')"
                        class="btn btn-primary profile-button">Ubah Profil dan Password</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Data Tambahan (Biodata) -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="p-3 py-4">
                <h4 class="profile-header">Data Tambahan</h4>
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>NIDN</th>
                        <td>{{ $user->nidn_user ?? 'Tidak Diketahui' }}</td>
                    </tr>
                    <tr>
                        <th>Gelar Akademik</th>
                        <td>{{ $user->gelar_akademik ?? 'Tidak Diketahui' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email_user ?? 'Tidak Diketahui' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Klasifikasi Data Berdasarkan ID -->
    <div class="row mt-4">
        <div class="col-md-12">
            <h4 class="profile-header">Sertifikasi Berdasarkan ID</h4>
            <table class="table table-bordered table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>ID Sertifikasi</th>
                        <th>Nama Sertifikasi</th>
                        <th>Jenis Sertifikasi</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Akhir</th>
                        <th>Vendor</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($sertifikasi)
                        @foreach ($sertifikasi as $data)
                            @if ($data->id_user == $user->id_user) <!-- Klasifikasi Berdasarkan ID User -->
                                <tr>
                                    <td>{{ $data->id_sertifikasi }}</td>
                                    <td>{{ $data->nama_sertif }}</td>
                                    <td>{{ $data->jenis_sertif }}</td>
                                    <td>{{ $data->tgl_mulai_sertif }}</td>
                                    <td>{{ $data->tgl_akhir_sertif }}</td>
                                    <td>{{ $data->id_vendor }}</td>
                                    <td>
                                        <button onclick="modalAction('{{ url('/sertifikasi/' . $data->id_sertifikasi . '/edit') }}')" class="btn btn-sm btn-warning">Edit</button>
                                        <button onclick="deleteData('{{ url('/sertifikasi/' . $data->id_sertifikasi) }}')" class="btn btn-sm btn-danger">Hapus</button>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data sertifikasi tersedia</td>
                        </tr>
                    @endisset
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    /* Tambahkan CSS di sini */
</style>
@endpush

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    function deleteData(url) {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert(response.message);
                    location.reload();
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan. Mohon coba lagi.');
                }
            });
        }
    }
</script>
@endpush