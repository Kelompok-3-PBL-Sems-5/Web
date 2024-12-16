@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Daftar rekomendasi</h3>
        <div class="card-tools">
            {{-- <a class="btn btn-sm btn-primary mt-1" href="{{ url('rekomendasi/create') }}">Tambah</a> --}}
            <button onclick="modalAction('{{ url('/rekomendasi/import') }}')" class="btn btn-info">Import rekomendasi</button>
                <a href="{{ url('/rekomendasi/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export rekomendasi</a>
                <a href="{{ url('/rekomendasi/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export rekomendasi</a>
            <button onclick="modalAction('{{ url('/rekomendasi/create_ajax') }}')" class="btn btn-success">Tambah Data (Ajax)</button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <table class="table table-bordered table-striped table-hover table-sm" id="table_rekomendasi">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Program</th>
                    <th>ID Vendor</th>
                    <th>Nama Program</th>
                    <th>Mata Kuliah</th>
                    <th>Bidang Minat</th>
                    <th>Tanggal Program</th>
                    <th>Level Program</th>
                    <th>Kuota Program</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" 
data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection
@push('js')
<script>
    // Fungsi modalAction untuk load konten ke dalam modal
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }
    var tablerekomendasi;
    $(document).ready(function() {
            tablerekomendasi = $('#table_rekomendasi').DataTable({
            // serverSide: true, jika ingin menggunakan server side processing
            serverSide: true, 
            ajax: {
                "url": "{{ url('rekomendasi/list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function(d) {
                    d.filter_rekomendasi = $('.filter_rekomendasi').val();
                }
            },
            columns: [
                {
                    // nomor urut dari laravel datatable addIndexColumn()
                    data: "DT_RowIndex", 
                    className: "text-center",
                    width: "5%",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "jenis_program", 
                    className: "",
                    width: "20%",
                    orderable: true, 
                    searchable: true
                },
                {
                    data: "vendor.nama_vendor", 
                    className: "",
                    width: "20%",
                    orderable: true, 
                    searchable: true
                },
                {
                    data: "nama_program", 
                    className: "",
                    width: "14%",
                    orderable: true, 
                    searchable: true
                },
                {
                    data: "damat.nama_damat", 
                    className: "",
                    width: "14%",
                    orderable: true, 
                    searchable: true
                },
                {
                    data: "dabim.nama_dabim", 
                    className: "",
                    width: "14%",
                    orderable: true, 
                    searchable: true
                },
                {
                    data: "tanggal_program", 
                    className: "",
                    width: "14%",
                    orderable: true, 
                    searchable: true
                },
                {
                    data: "level_program", 
                    className: "",
                    width: "14%",
                    orderable: true, 
                    searchable: true
                },
                {
                    data: "kuota_program", 
                    className: "",
                    width: "14%",
                    orderable: true, 
                    searchable: true
                },
                {
                    data: "aksi", 
                    className: "",
                    width: "14%",
                    orderable: false, 
                    searchable: false
                }
            ]
        });
        $('#table-rekomendasi_filter input').unbind().bind().on('keyup', function(e) {
                if (e.keyCode == 13) { // enter key
                    tablerekomendasi.search(this.value).draw();
                }
        });
            $('.filter_rekomendasi').change(function() {
                tablerekomendasi.draw();
        });
            $('#myModal').on('hidden.bs.modal', function() {
                tablerekomendasi.ajax.reload();
        });
    });
</script>
@endpush