@empty($periode)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/periode') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/periode/' . $periode->id_periode . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Periode</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Sertifikasi</label>
                        <div class="col-10">
                            <select class="form-control" id="id_sertifikasi" name="id_sertifikasi" required>
                                <option value="">- Pilih Sertifikasi -</option>
                                @foreach ($sertifikasi as $item)
                                    <option {{ $item->id_sertifikasi == $periode->id_sertifikasi ? 'selected' : '' }}
                                        value="{{ $item->id_sertifikasi }}">{{ $item->nama_sertifikasi }}</option>
                                @endforeach
                            </select>
                            <small id="error-id_sertifikasi" class="error-text form-text text-danger"></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">User</label>
                        <div class="col-10">
                            <select class="form-control" id="id_user" name="id_user" required>
                                <option value="">- Pilih User -</option>
                                @foreach ($user as $item)
                                    <option {{ $item->id_user == $periode->id_user ? 'selected' : '' }}
                                        value="{{ $item->id_user }}">{{ $item->nama_user }}</option>
                                @endforeach
                            </select>
                            <small id="error-id_user" class="error-text form-text text-danger"></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Status</label>
                        <div class="col-10">
                            <select class="form-control" id="status" name="status" required>
                                <option value="">- Pilih Status -</option>
                                <option value="Aktif" {{ $periode->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Tidak Aktif" {{ $periode->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            <small id="error-status" class="error-text form-text text-danger"></small>
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
                    id_sertifikasi: {
                        required: true
                    },
                    id_user: {
                        required: true
                    },
                    status: {
                        required: true
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
                                dataperiode.ajax.reload();
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