@empty($vendor)
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
                    <a href="{{ url('/vendor') }}" class="btn btn-warning">Kembali</a>
                </div>
            </div>
        </div>
    @else
        <form action="{{ url('/vendor/' . $vendor->id_vendor . '/update_ajax') }}" method="POST" id="form-edit">
            @csrf
            @method('PUT')
            <div id="modal-master" class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Data vendor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><spanaria-hidden="true">&times;</spanaria-hidden=></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Vendor</label>
                            <input value="{{ $vendor->nama_vendor }}" type="text" name="nama_vendor" id="nama_vendor"
                                class="form-control" required>
                            <small id="error-nama_vendor" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Alamat Vendor</label>
                            <input value="{{ $vendor->alamat_vendor}}" type="text" name="alamat_vendor" id="alamat_vendor"
                                class="form-control" required>
                            <small id="error-alamat_vendor" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>No. Telepon Vendor</label>
                            <input value="{{ $vendor->telp_vendor }}" type="text" name="telp_vendor" id="telp_vendor"
                                class="form-control" required>
                            <small id="error-telp_vendor" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Jenis Vendor</label>
                            <select name="jenis_vendor" id="jenis_vendor" class="form-control" required>
                                <option value="">-- Pilih Jenis Vendor --</option>
                                <option value="Sertifikasi" {{ $vendor->jenis_vendor == 'Sertifikasi' ? 'selected' : '' }}>Sertifikasi</option>
                                <option value="Pelatihan" {{ $vendor->jenis_vendor == 'Pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                            </select>
                            <small id="error-jenis_vendor" class="error-text form-text text-danger"></small>
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
                        nama_vendor: {
                            required: true,
                            minlength: 3,
                            maxlength: 20
                        },
                        alamat_vendor: {
                            required: true,
                            minlength: 3,
                            maxlength: 100
                        },
                        telp_vendor: {
                            required: true,
                            minlength: 3,
                            maxlength: 100
                        },
                        jenis_vendor: { 
                            required: true,
                            minlength: 3,
                            maxlength: 100 
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
                                    datavendor.ajax.reload();
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