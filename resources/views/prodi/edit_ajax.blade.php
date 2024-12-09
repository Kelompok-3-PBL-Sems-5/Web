@empty($prodi)
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
                    <a href="{{ url('/prodi') }}" class="btn btn-warning">Kembali</a>
                </div>
            </div>
        </div>
    @else
        <form action="{{ url('/prodi/' . $prodi->id_prodi . '/update_ajax') }}" method="POST" id="form-edit">
            @csrf
            @method('PUT')
            <div id="modal-master" class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Data prodi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><spanaria-hidden="true">&times;</spanaria-hidden=></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kode Prodi</label>
                            <input value="{{ $prodi->kode_prodi}}" type="text" name="kode_prodi" id="kode_prodi"
                                class="form-control" required>
                            <small id="error-kode_prodi" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Nama prodi</label>
                            <input value="{{ $prodi->nama_prodi }}" type="text" name="nama_prodi" id="nama_prodi"
                                class="form-control" required>
                            <small id="error-nama_prodi" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>NIDN User</label>
                            <input value="{{ $prodi->nidn_user }}" type="text" name="nidn_user" id="telp_user"
                                class="form-control" required>
                            <small id="error-nidn_user" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Jenjang</label>
                            <select name="jenjang" jenjang="jenjang" class="form-control" required>
                                <option value="">-- Jenjang --</option>
                                <option value="S2" {{ $prodi->jenjang == 'S2' ? 'selected' : '' }}>S2</option>
                                <option value="S3" {{ $prodi->jenjang == 'S3' ? 'selected' : '' }}>S3</option>
                            </select>
                            <small id="error-jenjang" class="error-text form-text text-danger"></small>
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
                kode_prodi: {
                    required: true,
                    minlength: 3,
                    maxlength: 20
                },
                nama_prodi: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                nidn_user: {
                    required: true,
                    minlength: 3,
                    maxlength: 50
                },
                jenjang: {
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
                            dataProdi.ajax.reload();
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