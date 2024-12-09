@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Daftar Kompetensi</h3>
        <div class="card-tools">
            {{-- <a class="btn btn-sm btn-primary mt-1" href="{{ url('kompetensi/create') }}">Tambah</a> --}}
            <button onclick="modalAction('{{ url('/kompetensi/import') }}')" class="btn btn-info">Import kompetensi</button>
                <a href="{{ url('/kompetensi/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export kompetensi</a>
                <a href="{{ url('/kompetensi/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export kompetensi</a>
            <button onclick="modalAction('{{ url('/kompetensi/create_ajax') }}')" class="btn btn-success">Tambah Data (Ajax)</button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <table class="table table-bordered table-striped table-hover table-sm" id="table_kompetensi">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kompetensi</th>
                    <th>Id User</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
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

    var tableKompetensi;
    $(document).ready(function() {
            tableKompetensi = $('#table_kompetensi').DataTable({
            // serverSide: true, jika ingin menggunakan server side processing
            serverSide: true, 
            ajax: {
                "url": "{{ url('kompetensi/list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function(d) {
                    d.filter_kompetensi = $('.filter_kompetensi').val();
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
                    data: "nama_kompetensi", 
                    className: "",
                    width: "20%",
                    orderable: true, 
                    searchable: true
                },
                {
                    data: "id_user",
                    className: "",
                    orderable: true,
                    searchable: true,
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
        $('#table-kompetensi_filter input').unbind().bind().on('keyup', function(e) {
                if (e.keyCode == 13) { // enter key
                    tablekompetensi.search(this.value).draw();
                }
        });
            $('.filter_kompetensi').change(function() {
                tablekompetensi.draw();
        });
    });
</script>
@endpush
