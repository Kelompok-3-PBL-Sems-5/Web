@empty($matkul)
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
                    <a href="{{ url('/matkul') }}" class="btn btn-warning">Kembali</a>
                </div>
            </div>
        </div>
    @else
        <form action="{{ url('/matkul/' . $matkul->id_matkul . '/update_ajax') }}" method="POST" id="form-edit">
            @csrf
            @method('PUT')
            <div id="modal-master" class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Data Mata Kuliah</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-2 control-label col-form-label">Nama User</label>
                            <div class="col-10">
                                <select class="form-control" id="id_user" name="id_user" required>
                                    <option value="">- Pilih user -</option>
                                    @foreach ($user as $item)
                                        <option {{ $item->id_user == $matkul->id_user ? 'selected' : '' }}
                                            value="{{ $item->id_user }}">{{ $item->nama_user }}</option>
                                    @endforeach
                                </select>
                                <small id="error-id_user" class="error-text form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 control-label col-form-label">Mata Kuliah</label>
                            <div class="col-10">
                                <input type="text" class="form-control" id="nama_matkul" name="nama_matkul"
                                    value="{{ $matkul->nama_matkul }}" required>
                                <small id="error-nama_matkul" class="error-text form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 control-label col-form-label">Mata Kuliah</label>
                            <div class="col-10">
                                <input type="text" class="form-control" id="kode_matkul" name="kode_matkul"
                                    value="{{ $matkul->kode_matkul }}" required>
                                <small id="error-kode_matkul" class="error-text form-text text-danger"></small>
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
                        nama_matkul: {
                            required: true,
                        }
                        kode_matkul: {
                            required: true,
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
                                    datamatkul.ajax.reload();
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