@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Daftar prodi</h3>
        <div class="card-tools">
            {{-- <a class="btn btn-sm btn-primary mt-1" href="{{ url('prodi/create') }}">Tambah</a> --}}
            <button onclick="modalAction('{{ url('/prodi/import') }}')" class="btn btn-info">Import prodi</button>
                <a href="{{ url('/prodi/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export prodi</a>
                <a href="{{ url('/prodi/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export prodi</a>
            <button onclick="modalAction('{{ url('/prodi/create_ajax') }}')" class="btn btn-success">Tambah Data (Ajax)</button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <table class="table table-bordered table-striped table-hover table-sm" id="table_prodi">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Prodi</th>
                    <th>Nama Prodi</th>
                    <th>NIDN User</th>
                    <th>Jenjang</th>
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

    var tableProdi;
    $(document).ready(function() {
            tableProdi = $('#table_prodi').DataTable({
            // serverSide: true, jika ingin menggunakan server side processing
            serverSide: true, 
            ajax: {
                "url": "{{ url('prodi/list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function(d) {
                    d.filter_prodi = $('.filter_prodi').val();
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
                    data: "kode_prodi", 
                    className: "",
                    width: "20%",
                    orderable: true, 
                    searchable: true
                },
                {
                    data: "nama_prodi", 
                    className: "",
                    width: "20%",
                    orderable: true, 
                    searchable: true
                },
                {
                    data: "nidn_user", 
                    className: "",
                    width: "14%",
                    orderable: true, 
                    searchable: true
                },
                {
                    data: "jenjang", 
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
        $('#table-prodi_filter input').unbind().bind().on('keyup', function(e) {
                if (e.keyCode == 13) { // enter key
                    tableprodi.search(this.value).draw();
                }
        });
            $('.filter_prodi').change(function() {
                tableprodi.draw();
        });
    });
</script>
@endpush
