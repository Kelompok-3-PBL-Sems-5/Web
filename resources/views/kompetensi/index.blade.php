@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Daftar Kompetensi</h3>
        <div class="card-tools">
            {{-- <a class="btn btn-sm btn-primary mt-1" href="{{ url('kompetensi/create') }}">Tambah</a> --}}
            {{-- <button onclick="modalAction('{{ url('/kompetensi/import') }}')" class="btn btn-info">Import kompetensi</button>
                <a href="{{ url('/kompetensi/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export kompetensi</a>
                <a href="{{ url('/kompetensi/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export kompetensi</a> --}}
            <button onclick="modalAction('{{ url('/kompetensi/create_ajax') }}')" class="btn btn-success">Tambah Data</button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            <div class="col-md-10">
                <div class="form-group row align-items-center">
                    <label class="col-2 control-label col-form-label">Filter Prodi:</label>
                    <div class="col-3">
                        <select class="form-control" id="id_prodi" name="id_prodi" required style="padding-left: 10px;">
                            <option value="" style="padding: 5px 10px;">- Semua -</option>
                            @foreach ($prodi as $item)
                                <option value="{{ $item->id_prodi }}">{{ $item->nama_prodi}}</option>
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

        <table class="table table-bordered table-striped table-hover table-sm" id="table_kompetensi">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Prodi</th>
                    <th>Nama Kompetensi</th>
                    {{-- <th>Id User</th> --}}
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal untuk Form Import -->
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
                    d.id_prodi = $('#id_prodi').val();
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
                    // mengambil data level hasil dari ORM berelasi
                    data: "prodi.nama_prodi",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "nama_kompetensi", 
                    className: "",
                    width: "20%",
                    orderable: true, 
                    searchable: true
                },
                // {
                //     data: "id_user",
                //     className: "",
                //     orderable: true,
                //     searchable: true,
                // },
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
            $('#id_prodi').on('change',function(){
                tablekompetensi.ajax.reload();
        });
    });
</script>
@endpush

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

