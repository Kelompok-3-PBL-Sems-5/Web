@empty($pengajuan_sertifikasi)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                        Data yang anda cari tidak ditemukan
                    </div>
                    <a href="{{ url('/ajukan_sertifikasi') }}" class="btn btn-warning">Kembali</a>
                </div>
            </div>
        </div>
    @else
        <form action="{{ url('/ajukan_sertifikasi/' . $pengajuan_sertifikasi->id_pengsertifikasi . '/update_ajax') }}" method="POST" id="form-edit">
            @csrf
            @method('PUT')
            <div id="modal-master" class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Data Sertifikasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-2 control-label col-form-label">Nama User</label>
                                <div class="col-10">
                                    <select class="form-control" id="id_user" name="id_user" required>
                                        <option value="">- Pilih user -</option>
                                        @foreach ($user as $item)
                                            <option {{ $item->id_user == $pengajuan_sertifikasi->id_user ? 'selected' : '' }}
                                                value="{{ $item->id_user }}">{{ $item->nama_user }}</option>
                                        @endforeach
                                    </select>
                                    <small id="error-id_user" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-2 control-label col-form-label">Nama Vendor</label>
                                <div class="col-10">
                                    <select class="form-control" id="id_vendor" name="id_vendor" required>
                                        <option value="">- Pilih vendor -</option>
                                        @foreach ($vendor as $item)
                                            <option {{ $item->id_vendor == $pengajuan_sertifikasi->id_vendor ? 'selected' : '' }}
                                                value="{{ $item->id_vendor }}">{{ $item->nama_vendor }}</option>
                                        @endforeach
                                    </select>
                                    <small id="error-id_vendor" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-2 control-label col-form-label">Judul Sertifikasi</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="judul" name="judul" value="{{ $pengajuan_sertifikasi->judul }}" required>
                                    <small id="error-judul" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-2 control-label col-form-label">Tujuan</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="tujuan" name="tujuan" value="{{ $pengajuan_sertifikasi->tujuan }}" required>
                                    <small id="error-tujuan" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-2 control-label col-form-label">Relevansi dengan Tugas Akademik</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="relevansi" name="relevansi" value="{{ $pengajuan_sertifikasi->relevansi }}" required>
                                    <small id="error-relevansi" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-2 control-label col-form-label">Tanggal Pelaksanaan</label>
                                <div class="col-10">
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $pengajuan_sertifikasi->tanggal }}" required>
                                    <small id="error-tanggal" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-2 control-label col-form-label">Lokasi (Online/Offline)</label>
                                <div class="col-10">
                                    <select class="form-control" id="lokasi" name="lokasi" required>
                                        <option value="">- Pilih Lokasi -</option>
                                        <option value="Online" {{ old('lokasi', $pengajuan_sertifikasi->lokasi) == 'Online' ? 'selected' : '' }}>Online</option>
                                        <option value="Offline" {{ old('lokasi', $pengajuan_sertifikasi->lokasi) == 'Offline' ? 'selected' : '' }}>Offline</option>
                                    </select>
                                    <small id="error-lokasi" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-2 control-label col-form-label">Biaya</label>
                                <div class="col-10">
                                    <input type="number" class="form-control" id="biaya" name="biaya" value="{{ $pengajuan_sertifikasi->biaya }}" required>
                                    <small id="error-biaya" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-2 control-label col-form-label">Sumber Dana</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="dana" name="dana" value="{{ $pengajuan_sertifikasi->dana }}" required>
                                    <small id="error-dana" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-2 control-label col-form-label">Rencana Implementasi</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="implementasi" name="implementasi" value="{{ $pengajuan_sertifikasi->implementasi }}" required>
                                    <small id="error-implementasi" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-2 control-label col-form-label">Link Informasi Resmi</label>
                                <div class="col-10">
                                    <input type="url" class="form-control" id="link" name="link" value="{{ $pengajuan_sertifikasi->link }}" required>
                                    <small id="error-link" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-2 control-label col-form-label">Status</label>
                                <div class="col-10">
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="">- Pilih Status -</option>
                                        <option value="Terkirim" {{ old('status', $pengajuan_sertifikasi->status) == 'Terkirim' ? 'selected' : '' }}>Terkirim</option>
                                        <option value="Disetujui" {{ old('status', $pengajuan_sertifikasi->status) == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                        <option value="Ditolak" {{ old('status', $pengajuan_sertifikasi->status) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                    <small id="error-status" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-2 control-label col-form-label">Komentar Pimjur</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="komentar" name="komentar" value="{{ $pengajuan_sertifikasi->komentar }}">
                                    <small id="error-komentar" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                        
                        </div>                        
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
        <script>
            $(document).ready(function() {
                $("#form-edit").validate({
                    rules: {
                        id_user: {
                        required: true,
                        number: true
                    },
                    id_vendor: {
                        required: true,
                        number: true
                    },
                    judul: {
                        required: true,
                        minlength: 3
                    },
                    tujuan: {
                        required: true,
                        minlength: 3
                    },
                    relevansi: {
                        required: true,
                        minlength: 3
                    },
                    tanggal: {
                        required: true,
                        date: true
                    },
                    lokasi: {
                        required: true
                    },
                    biaya: {
                        required: true,
                        number: true
                    },
                    dana: {
                        required: true,
                        minlength: 3
                    },
                    implementasi: {
                        required: true,
                        minlength: 3
                    },
                    link: {
                        required: false,
                        url: true
                    },
                    status: {
                        required: true
                    },
                    komentar: {
                        required: false,
                    }
                    },
                    submitHandler: function(form) {
                        $.ajax({
                            url: form.action,
                            type: form.method,
                            data: $(form).serialize(),
                            success: function(response) {
                                if (response.status) {
                                    $('#myModal').modal('hide');
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.message
                                    });
                                    datapengajuan_sertifikasi.ajax.reload();
                                } else {
                                    $('.error-text').text('');
                                    $.each(response.msgField, function(prefix, val) {
                                        $('#error-' + prefix).text(val[0]);
                                    });
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Terjadi Kesalahan',
                                        text: response.message
                                    });
                                }
                            }
                        });
                        return false;
                    },
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    }
                });
            });
        </script>
    @endempty