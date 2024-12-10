@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Pelatihan</h3>
            <div class="card-tools">
                <!-- Tombol untuk Import Pelatihan -->
            <button onclick="modalAction('{{ url('/data_pelatihan/import') }}')" class="btn btn-info">Import pelatihan</button>
            <!-- Tombol untuk Export Data ke Excel -->
            <a href="{{ url('/data_pelatihan/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export pelatihan</a>
            <!-- Tombol untuk Export Data ke PDF -->
            <a href="{{ url('/data_pelatihan/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export pelatihan</a>
            <!-- Tombol Tambah Data (Ajax) -->
            <button onclick="modalAction('{{ url('/data_pelatihan/create_ajax') }}')" class="btn btn-success">Tambah Data (Ajax)</button>
            </div>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- <!-- Untuk Filter data -->
            <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2"> --}}
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group row align-items-center">
                            <label class="col-2 control-label col-form-label">Filter user:</label>
                            <div class="col-3">
                                <select class="form-control" id="id_user" name="id_user" required style="padding-left: 10px;">
                                    <option value="" style="padding: 5px 10px;">- Semua -</option>
                                    @foreach ($user as $item)
                                        <option value="{{ $item->id_user }}">{{ $item->nama_user}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                    
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group row align-items-center">
                            <label class="col-2 control-label col-form-label">Filter vendor:</label>
                            <div class="col-3">
                                <select class="form-control" id="id_vendor" name="id_vendor" required>
                                    <option value="" style="padding: 5px 10px;">- Semua -</option>
                                    @foreach ($vendor as $item)
                                        <option value="{{ $item->id_vendor }}">{{ $item->nama_vendor }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group row align-items-center">
                            <label class="col-2 control-label col-form-label">Filter mata kuliah:</label>
                            <div class="col-3">
                                <select class="form-control" id="id_matkul" name="id_matkul" required>
                                    <option value="" style="padding: 5px 10px;">- Semua -</option>
                                    @foreach ($matkul as $item)
                                        <option value="{{ $item->id_matkul }}">{{ $item->nama_matkul }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>  

                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group row align-items-center">
                            <label class="col-2 control-label col-form-label">Filter bidang minat:</label>
                            <div class="col-3">
                                <select class="form-control" id="id_bidang_minat" name="id_bidang_minat" required>
                                    <option value="" style="padding: 5px 10px;">- Semua -</option>
                                    @foreach ($bidang_minat as $item)
                                        <option value="{{ $item->id_bidang_minat }}">{{ $item->bidang_minat }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div> 
                 

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered table-striped table-hover table-sm" id="table_pelatihan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama User</th>
                        <th>Nama Vendor</th>
                        <th>Nama Mata Kuliah</th>
                        <th>Nama Bidang Minat</th>
                        <th>Nama Pelatihan</th>
                        <th>Jenis Pelatihan</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Akhir</th>
                        <th>Level Pelatihan</th>
                        <th>Jenis Pendanaan</th>
                        <th>Bukti Pelatihan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

<!-- Modal untuk Form Import -->
<div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div>

@endsection
@push('css')
<style>
    /* Card Styling */
    .card {
        background: #ffffff; /* Putih untuk tampilan yang bersih */
        border-radius: 10px; 
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
        transition: transform 0.2s ease; 
    }

    .card:hover {
        transform: translateY(-5px); 
    }

    .card-header {
        background: #007bff; /* Biru yang lebih lembut */
        color: white;
        border-top-left-radius: 10px; 
        border-top-right-radius: 10px; 
        padding: 15px; 
        font-weight: bold; 
        box-shadow: inset 0 -2px 5px rgba(0, 0, 0, 0.1); 
    }

    .card-tools .btn {
        margin-right: 8px; 
        border-radius: 20px; 
        padding: 6px 12px; 
        transition: background 0.3s ease; 
    }

    .btn-success {
        background: #28a745; /* Hijau yang lembut */
        border: none; 
        color: white; 
    }

    .btn-warning {
        background: #ffc107; /* Kuning lembut */
        border: none; 
        color: black; 
    }

    .btn-primary {
        background: #0056b3; /* Biru gelap */
        border: none; 
        color: white; 
    }

    .btn-info {
        background: #17a2b8; /* Biru tua yang lebih lembut */
        border: none; 
        color: white; 
    }

    .btn:hover {
        opacity: 0.9; 
    }

    /* Table Styling */
    #table_level {
        border-collapse: separate; 
        border-spacing: 0 10px; 
    }

    #table_level thead {
        background: #007bff; 
        color: white; 
        border-radius: 10px; 
    }

    #table_level tbody tr {
        background: #f8f9fa; 
        border-radius: 10px; 
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
        transition: background 0.3s, transform 0.3s; 
    }

    #table_level tbody tr:hover {
        background: #e2e6ea; 
        transform: scale(1.02); 
    }

    /* Modal Styling */
    .modal-content {
        background: #ffffff; 
        border-radius: 10px; 
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
    }

    /* Alerts Styling */
    .alert {
        border-radius: 10px; 
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
        padding: 10px 15px; 
    }

    /* Input Search Custom */
    #table-level_filter input {
        border-radius: 20px; 
        padding: 8px 15px; 
        border: 1px solid #ddd; 
        outline: none; 
        transition: border-color 0.3s, box-shadow 0.3s; 
    }

    #table-level_filter input:focus {
        border-color: #007bff; 
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.5); 
    }
</style>
@endpush
@push('js')
    <script>

    // Fungsi modalAction untuk memuat konten ke dalam modal
    function modalAction(url = ''){
        $('#myModal').load(url, function(){
            $('#myModal').modal('show');
        });
    }
    var datapelatihan;
        $(document).ready(function() {
                datapelatihan = $('#table_pelatihan').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                serverSide: true,
                ajax: {
                    "url": "{{ url('data_pelatihan/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function (d) {
                        d.id_vendor = $('#id_vendor').val();
                        d.id_user = $('#id_user').val();
                        d.id_matkul = $('#id_matkul').val();
                        d.id_bidang_minat = $('#id_bidang_minat').val();
                    }
                },
                columns: [{
                    // nomor urut dari laravel datatable addIndexColumn()
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    // Menampilkan Nama User dari relasi user
                    data: "user.nama_user",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    // Menampilkan Nama Vendor dari relasi vendor
                    data: "vendor.nama_vendor",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "matkul.nama_matkul",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "bidang_minat.bidang_minat",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    // Menampilkan Nama Pelatihan
                    data: "nama_pelatihan",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    // Menampilkan Jenis Pelatihan
                    data: "jenis_pelatihan",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    // Menampilkan Tanggal Mulai Pelatihan
                    data: "tgl_mulai",
                    className: "text-right",
                    orderable: true,
                    searchable: false
                }, {
                    // Menampilkan Tanggal Akhir Pelatihan
                    data: "tgl_akhir",
                    className: "text-right",
                    orderable: true,
                    searchable: false
                }, {
                    // Menampilkan Level Pelatihan
                    data: "level_pelatihan",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    // Menampilkan Jenis Pendanaan
                    data: "jenis_pendanaan",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    // Menampilkan Bukti Pelatihan
                    data: "bukti_pelatihan",
                    className: "",
                    orderable: true,
                    searchable: true,
                    "render": function(data) {
                        // Cek jika data ada
                        if (data) {
                            // Gunakan URL yang berasal dari data
                            return '<a href="' + data + '" target="_blank">Lihat Bukti</a>';
                        }
                        return 'Bukti Tidak Tersedia'; // Jika tidak ada data, tampilkan teks fallback
                    }
                }, {
                    // Menampilkan Status Pelatihan
                    data: "status",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    // Aksi untuk setiap baris data
                    data: "aksi",
                    className: "",
                    orderable: false,
                    searchable: false
                }]
            });
            // Memperbarui DataTable ketika ada perubahan pada filter
            $('#id_vendor').on('change',function(){
                datapelatihan.ajax.reload();
            });
            $('#id_user').on('change',function(){
                datapelatihan.ajax.reload();
            });
            $('#id_matkul').on('change',function(){
                datasertifikasi.ajax.reload();
            });
            $('#id_bidang_minat').on('change',function(){
                datasertifikasi.ajax.reload();
            });
        });
    </script>
@endpush