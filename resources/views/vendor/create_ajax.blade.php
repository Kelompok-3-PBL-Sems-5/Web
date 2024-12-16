<form action="{{ url('/vendor/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Vendor</label>
                    <input value="" type="text" name="nama_vendor" id="nama_vendor" class="form-control" required>
                    <small id="error-nama_vendor" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Alamat Vendor</label>
                    <input value="" type="text" name="alamat_vendor" id="alamat_vendor" class="form-control" required>
                    <small id="error-alamat_vendor" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Jenis Vendor</label>
                    <select name="jenis_vendor" id="jenis_vendor" class="form-control" required>
                        <option value="">-- Pilih Jenis Vendor --</option>
                        <option value="Sertifikasi">Sertifikasi</option>
                        <option value="Pelatihan">Pelatihan</option>
                    </select>
                    <small id="error-jenis_vendor" class="error-text form-text text-danger"></small>
                </div>         
                <div class="form-group">
                    <label>Telepon Vendor</label>
                    <input value="" type="text" name="telp_vendor" id="telp_vendor" class="form-control" required>
                    <small id="error-telp_vendor" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Alamat Web</label>
                    <input value="" type="text" name="alamat_web" id="alamat_web" class="form-control" required>
                    <small id="error-alamat_web" class="error-text form-text text-danger"></small>
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
        $("#form-tambah").validate({
            rules: {
                nama_vendor: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                alamat_vendor: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                jenis_vendor: {
                    required: true,
                },
                telp_vendor: {
                    required: true,
                    minlength: 3,
                    maxlength: 20,
                    digits: true
                },
                alamat_web: {
                    required: true,
                    minlength: 3,
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