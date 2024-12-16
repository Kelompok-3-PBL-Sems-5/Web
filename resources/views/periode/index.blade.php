@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Periode Sertifikasi</h3>
            <div class="card-tools">
                <!-- Tombol Tambah Data (Ajax) -->
                <button onclick="modalAction('{{ url('/periode/create_ajax') }}')" class="btn btn-success">Tambah Periode (Ajax)</button>
            </div>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered table-striped table-hover table-sm" id="table_periode">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Sertifikasi</th>
                        <th>User</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

<!-- Modal untuk Form -->
<div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div>

@endsection
@push('css')
<style>
    /* Card Styling */
.card {
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease;
}

.card:hover {
    transform: translateY(-5px);
}

.card-header {
    background: #007bff;
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
    background: #28a745;
    border: none;
    color: white;
}

/* Table Styling */
#table_periode {
    border-collapse: separate;
    border-spacing: 0 10px;
}

#table_periode thead {
    background: #007bff;
    color: white;
    border-radius: 10px;
}

#table_periode tbody tr {
    background: #f8f9fa;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: background 0.3s, transform 0.3s;
}

#table_periode tbody tr:hover {
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
#table_periode_filter input {
    border-radius: 20px;
    padding: 8px 15px;
    border: 1px solid #ddd;
    outline: none;
    transition: border-color 0.3s, box-shadow 0.3s;
}

#table_periode_filter input:focus {
    border-color: #007bff;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
}
</style>
@endpush
@push('js')
<script>
    var dataperiode;
    $(document).ready(function() {
        dataperiode = $('#table_periode').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('periode/list') }}",
                "dataType": "json",
                "type": "POST"
            },
            columns: [{
                data: "DT_RowIndex",
                className: "text-center",
                orderable: false,
                searchable: false
            }, {
                data: "sertifikasi.nama_sertifikasi",
                className: "",
                orderable: true,
                searchable: true
            }, {
                data: "user.nama_user",
                className: "",
                orderable: true,
                searchable: true
            }, {
                data: "status",
                className: "",
                orderable: true,
                searchable: true
            }, {
                data: "aksi",
                className: "",
                orderable: false,
                searchable: false
            }]
        });
    });

    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }
</script>
@endpush