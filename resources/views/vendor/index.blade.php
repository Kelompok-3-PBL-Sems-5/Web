@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Daftar Vendor</h3>
        <div class="card-tools">
            {{-- <a class="btn btn-sm btn-primary mt-1" href="{{ url('vendor/create') }}">Tambah</a> --}}
            <button onclick="modalAction('{{ url('/vendor/import') }}')" class="btn btn-info">Import vendor</button>
                <a href="{{ url('/vendor/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export vendor</a>
                <a href="{{ url('/vendor/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export vendor</a>
            <button onclick="modalAction('{{ url('/vendor/create_ajax') }}')" class="btn btn-success">Tambah Data (Ajax)</button>
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
                    <label class="col-2 control-label col-form-label">Filter jenis vendor:</label>
                    <div class="col-3">
                        <select class="form-control filter_vendor" name="jenis_vendor" style="padding-left: 10px;">
                            <option value="">- Semua -</option>
                            @foreach ($vendor->unique('jenis_vendor') as $item)
                                <option value="{{ $item->jenis_vendor }}">{{ $item->jenis_vendor }}</option>
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

        <table class="table table-bordered table-striped table-hover table-sm" id="table_vendor">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Vendor</th>
                    <th>Alamat Vendor</th>
                    <th>Jenis Vendor</th>
                    <th>No. Telepon</th>
                    <th>Alamat Web</th>
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
    #table_vendor {
        border-collapse: separate; 
        border-spacing: 0 10px; 
    }

    #table_vendor thead {
        background: #007bff; 
        color: white; 
        border-radius: 10px; 
    }

    #table_vendor tbody tr {
        background: #f8f9fa; 
        border-radius: 10px; 
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
        transition: background 0.3s, transform 0.3s; 
    }

    #table_vendor tbody tr:hover {
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
    #table-vendor_filter input {
        border-radius: 20px; 
        padding: 8px 15px; 
        border: 1px solid #ddd; 
        outline: none; 
        transition: border-color 0.3s, box-shadow 0.3s; 
    }

    #table-vendor_filter input:focus {
        border-color: #007bff; 
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.5); 
    }
</style>
@endpush

@push('js')
<script>

    // Fungsi modalAction untuk load konten ke dalam modal
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    var tableVendor;
    $(document).ready(function() {
            tableVendor = $('#table_vendor').DataTable({
            // serverSide: true, jika ingin menggunakan server side processing
            serverSide: true, 
            ajax: {
                "url": "{{ url('vendor/list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function(d) {
                    d.filter_vendor = $('.filter_vendor').val();
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
                    data: "nama_vendor", 
                    className: "",
                    width: "20%",
                    orderable: true, 
                    searchable: true
                },
                {
                    data: "alamat_vendor", 
                    className: "",
                    width: "20%",
                    orderable: true, 
                    searchable: false
                },
                {
                    data: "jenis_vendor", 
                    className: "",
                    width: "14%",
                    orderable: true, 
                    searchable: true
                },
                {
                    data: "telp_vendor", 
                    className: "",
                    width: "14%",
                    orderable: true, 
                    searchable: false
                },
                {
                    data: "alamat_web",
                    className: "",
                    width: "14%",
                    orderable: true,
                    searchable: false,
                    "render": function(data) {
                        // Cek jika data ada
                        if (data) {
                            // Gunakan URL yang berasal dari data
                            return '<a href="' + data + '" target="_blank">Lihat Web</a>';
                        }
                        return 'Link Tidak Tersedia'; // Jika tidak ada data, tampilkan fallback
                    }

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
        $('#table-vendor_filter input').unbind().bind().on('keyup', function(e) {
                if (e.keyCode == 13) { // enter key
                    tableVendor.search(this.value).draw();
                }
        });
        $('.filter_vendor').change(function() {
            console.log("Filter Changed:", $(this).val()); // Debugging
            tableVendor.draw();
        });

    });
</script>
@endpush
