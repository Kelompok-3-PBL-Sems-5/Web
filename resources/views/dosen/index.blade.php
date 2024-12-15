@extends('layouts.template')
@section('content')
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/user/import') }}')" class="btn btn-info">Import User</button>
                <button onclick="modalAction('{{ url('/user/create_ajax') }}')" class="btn btn-success">Tambah Data (Ajax)</button>
            </div>
        </div>
        <div class="card-body">
            <!-- Notifikasi -->
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Filter Level Pengguna -->
            <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Filter Level:</label>
                        <div class="col-3">
                            <select class="form-control" id="id_level" name="id_level">
                                <option value="">- Semua Level -</option>
                                @foreach ($level as $item)
                                    <option value="{{ $item->id_level }}">{{ $item->nama_level }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Filter berdasarkan level pengguna</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Data Pengguna -->
            <table class="table table-bordered table-striped table-hover table-sm" id="table-user">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>NIDN</th>
                        <th>Gelar Akademik</th>
                        <th>Email</th>
                        <th>Level Pengguna</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var tableUser;
        $(document).ready(function() {
            tableUser = $('#table-user').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('dosen/list') }}",
                    type: "POST",
                    data: function(d) {
                        d.level_id = $('#id_level').val();
                    }
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", width: "5%", orderable: false, searchable: false },
                    { data: "username_user", width: "10%", orderable: true, searchable: true },
                    { data: "nama_user", width: "15%", orderable: true, searchable: true },
                    { data: "nidn_user", width: "10%", orderable: true, searchable: true },
                    { data: "gelar_akademik", width: "10%", orderable: true, searchable: true },
                    { data: "email_user", width: "15%", orderable: true, searchable: true },
                    { data: "level.nama_level", width: "10%", orderable: true, searchable: false },
                    {
                        data: "foto",
                        width: "10%",
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            if (data) {
                                // Menampilkan gambar dari blob
                                const base64Data = `data:image/jpeg;base64,${data}`;
                                return `<img src="${base64Data}" width="50px" height="50px" class="img-circle elevation-2" alt="User Photo">`;
                            }
                            return 'Foto Kosong';
                        }
                    },
                    { data: "aksi", className: "text-center", width: "10%", orderable: false, searchable: false }
                ]
            });

            // Filter berdasarkan level pengguna
            $('#id_level').change(function() {
                tableUser.draw();
            });
        });
    </script>
@endpush
