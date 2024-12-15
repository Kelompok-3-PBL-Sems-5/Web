<form action="{{ url('/user/ajax') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Level Pengguna</label>
                    <select name="id_level" id="id_level" class="form-control" required>
                        <option value="">- Pilih Level -</option>
                        @foreach ($level as $l)
                            <option value="{{ $l->id_level }}">{{ $l->nama_level }}</option>
                        @endforeach
                    </select>
                    <small id="error-level_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input value="" type="text" name="username_user" id="username_user" class="form-control" required>
                    <small id="error-username" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <input value="" type="text" name="nama_user" id="nama_user" class="form-control" required>
                    <small id="error-nama" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input value="" type="password" name="password_user" id="password_user" class="form-control" required>
                    <small id="error-password" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>NIDN</label>
                    <input value="" type="text" name="nidn_user" id="nidn_user" class="form-control" required>
                    <small id="error-nidn" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Gelar Akademik</label>
                    <input value="" type="text" name="gelar_akademik" id="gelar_akademik" class="form-control" required>
                    <small id="error-gelar" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input value="" type="text" name="email_user" id="email_user" class="form-control" required>
                    <small id="error-gelar" class="error-text form-text text-danger"></small>
                <div class="form-group">
                    <label>Foto</label>
                    <input value="" type="file" name="foto" id="foto" class="form-control" accept=".png,.jpg,.jpeg">
                    <small id="error-foto" class="error-text form-text text-danger"></small>
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
                id_level: {
                    required: true,
                    number: true
                },
                username_user: {
                    required: true,
                    minlength: 3,
                    maxlength: 20
                },
                nama_user: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                password_user: {
                    required: true,
                    minlength: 6,
                    maxlength: 20
                },
                nidn_user: {
                    required: true,
                    minlength: 3,
                    maxlength: 10
                },
                gelar_akademik: {
                    required: true,
                    minlength: 3,
                    maxlength: 8
                },
                email_user: {
                    required: true,
                    minlength: 4,
                    maxlength: any
                },
                foto: {
                    accept: "png,jpg,jpeg"
                },
            },
            submitHandler: function(form) {
                var formData = new FormData(
                form);
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                            processData: false, // setting processData dan contentType ke false, untuk menghandle file 
                            contentType: false,
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            tableUser.ajax.reload();
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