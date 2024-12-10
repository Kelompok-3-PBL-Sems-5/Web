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
</div>
@endsection

@push('css')
    <style>
        body {
            background-color: #e9ecef; /* Latar belakang halaman abu-abu terang */
            font-family: 'Arial', sans-serif; /* Font yang lebih modern */
        }

        .profile-container {
            border: 3px solid #007bff; /* Garis tepi biru */
            border-radius: 20px; /* Sudut membulat */
            padding: 25px; /* Ruang dalam yang lebih banyak */
            background-color: #ffffff; /* Latar belakang putih */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25); /* Bayangan lebih kuat */
            transition: transform 0.3s, box-shadow 0.3s; /* Transisi untuk efek hover */
        }

        .profile-container:hover {
            transform: translateY(-5px); /* Mengangkat sedikit saat hover */
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3); /* Bayangan lebih kuat saat hover */
        }

        .photo-date {
            color: #6c757d; /* Warna teks abu-abu gelap */
            font-size: 0.9em; /* Ukuran font lebih kecil */
            margin-top: 10px; /* Jarak atas */
        }

        .rounded-circle {
            border-radius: 50%; /* Mengubah foto menjadi lingkaran */
            /* border: 5px solid #007bff; Garis tepi foto */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Bayangan pada foto */
            transition: transform 0.3s; /* Transisi untuk efek hover pada foto */
        }

        .rounded-circle:hover {
            transform: scale(1.05); /* Memperbesar sedikit foto saat hover */
        }

        .table {
            margin-top: 20px; /* Jarak atas untuk tabel */
            border-radius: 10px; /* Sudut tabel membulat */
            overflow: hidden; /* Menghilangkan sudut tajam */
            background-color: #ffffff; /* Latar belakang tabel putih */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Bayangan tabel */
        }

        .table th {
            background-color: #007bff; /* Latar belakang kolom header tabel */
            color: #ffffff; /* Warna teks putih untuk header */
            text-align: center; /* Teks di tengah */
            padding: 10px; /* Ruang dalam header */
        }

        .table td {
            color: #495057; /* Warna teks untuk data tabel */
            text-align: center; /* Teks di tengah */
            padding: 10px; /* Ruang dalam sel tabel */
            transition: background-color 0.3s; /* Transisi untuk efek hover pada sel */
        }

        .table td:hover {
            background-color: #f8f9fa; /* Latar belakang sel saat hover */
        }

        .profile-button {
            background-color: #007bff; /* Warna tombol biru */
            color: white; /* Warna teks putih */
            font-weight: bold; /* Teks tebal untuk tombol */
            padding: 10px 20px; /* Ruang dalam tombol */
            border-radius: 5px; /* Sudut tombol membulat */
            transition: background-color 0.3s, transform 0.3s; /* Transisi untuk efek hover */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Bayangan pada tombol */
        }

        .profile-button:hover {
            background-color: #0056b3; /* Warna tombol biru lebih gelap saat hover */
            transform: scale(1.05); /* Memperbesar sedikit tombol saat hover */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Bayangan lebih kuat saat hover */
        }

        @media (max-width: 768px) {
            .profile-container {
                padding: 15px; /* Ruang dalam lebih sedikit di layar kecil */
            }

            .table th, .table td {
                font-size: 0.9em; /* Ukuran font lebih kecil di layar kecil */
                padding: 8px; /* Ruang dalam lebih sedikit di layar kecil */
            }
        }

        .profile-header {
            background-color: #03316A; /* Latar belakang biru untuk header */
            color: white; /* Warna teks putih */
            padding: 15px; /* Ruang dalam */
            border-radius: 10px; /* Sudut membulat */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Bayangan untuk kedalaman */
            text-align: center; /* Teks di tengah */
            font-size: 1.5em; /* Ukuran font lebih besar */
            font-weight: bold; /* Teks tebal */
            margin-bottom: 20px; /* Jarak bawah untuk pemisah */
        }
    </style>
@endpush


@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var profile;
        $(document).ready(function() {
            profile = $('#profile').on({
                autoWidth: false,
                serverSide: true,
                ajax: {
                    "url": "{{ url('user/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.id_user = $('#id_user').val();
                    }
                },
            });
            $('#profile').on('change', function() {
                profile.ajax.reload();
            });
        });
    </script>
@endpush

{{-- @extends('layouts.template')
@section('content')
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    <div class="container rounded bg-white border">
        <div class="row" id="profile">
            <div class="col-md-4 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex flex-column align-items-center text-center p-3 "><img class="rounded mt-3 mb-2"
                            width="250px" src=" {{ asset($user->foto) }} ">
                    </div>
                    <div onclick="modalAction('{{ url('/profile/' . session('id_user') . '/edit_foto') }}')"
                        class="mt-4 text-center"><button class="btn btn-primary profile-button" type="button">Edit
                            Foto</button></div>
                </div>
            </div>
            <div class="col-md-8 border-right">
                <div class="p-3 py-4">
                    <div class="d-flex align-items-center">
                        <h4 class="text-right">Profile Settings</h4>
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
                            class="btn btn-primary profile-button">Edit
                            Profile</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
            </div>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
        var profile;
        $(document).ready(function() {
            profile = $('#profile').on({
                autoWidth: false,
                serverSide: true,
                ajax: {
                    "url": "{{ url('user/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.id_user = $('#id_user').val();
                    }
                },
            });
            $('#profile').on('change', function() {
                profile.ajax.reload();
            });
        });
    </script>
@endpush --}}