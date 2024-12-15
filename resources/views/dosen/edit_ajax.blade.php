@empty($user)
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
                    <a href="{{ url('/user') }}" class="btn btn-warning">Kembali</a>
                </div>
            </div>
        </div>
    @else
        <form action="{{ url('/user/' . $user->id_user . '/update_ajax') }}" method="POST" id="form-edit"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div id="modal-master" class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <!-- Level Pengguna -->
                        <div class="form-group">
                            <label>Level Pengguna</label>
                            <select name="id_level" id="id_level" class="form-control" required>
                                <option value="">- Pilih Level -</option>
                                @foreach ($level as $l)
                                    <option {{ $l->id_level == $user->id_level ? 'selected' : '' }}
                                        value="{{ $l->id_level }}">{{ $l->level_nama }}</option>
                                @endforeach
                            </select>
                            <small id="error-id_level" class="error-text form-text text-danger"></small>
                        </div>

                        <!-- Username -->
                        <div class="form-group">
                            <label>Username</label>
                            <input value="{{ $user->username_user }}" type="text" name="username_user" id="username_user"
                                class="form-control" required>
                            <small id="error-username_user" class="error-text form-text text-danger"></small>
                        </div>

                        <!-- Nama -->
                        <div class="form-group">
                            <label>Nama</label>
                            <input value="{{ $user->nama_user }}" type="text" name="nama_user" id="nama_user"
                                class="form-control" required>
                            <small id="error-nama_user" class="error-text form-text text-danger"></small>
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password_user" id="password_user" class="form-control">
                            <small class="form-text text-muted">Abaikan jika tidak ingin mengubah password</small>
                            <small id="error-password_user" class="error-text form-text text-danger"></small>
                        </div>

                        <!-- NIDN -->
                        <div class="form-group">
                            <label>NIDN</label>
                            <input value="{{ $user->nidn_user }}" type="text" name="nidn_user" id="nidn_user"
                                class="form-control">
                            <small id="error-nidn_user" class="error-text form-text text-danger"></small>
                        </div>

                        <!-- Gelar Akademik -->
                        <div class="form-group">
                            <label>Gelar Akademik</label>
                            <input value="{{ $user->gelar_akademik }}" type="text" name="gelar_akademik"
                                id="gelar_akademik" class="form-control">
                            <small id="error-gelar_akademik" class="error-text form-text text-danger"></small>
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label>Email</label>
                            <input value="{{ $user->email_user }}" type="email" name="email_user" id="email_user"
                                class="form-control">
                            <small id="error-email_user" class="error-text form-text text-danger"></small>
                        </div>

                        <!-- Foto -->
                        <div class="form-group">
                            <label>Foto</label>
                            <input type="file" name="foto" id="foto" class="form-control"
                                accept=".png,.jpg,.jpeg">
                            <small class="form-text text-muted">Abaikan jika tidak ingin mengubah foto</small>
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
            $("#form-edit").validate({
                rules: {
                    id_level: {
                        required: true,
                        number: true
                    },
                    username_user: {
                        required: true,
                        minlength: 3,
                        maxlength: 50
                    },
                    nama_user: {
                        required: true,
                        minlength: 3,
                        maxlength: 100
                    },
                    password_user: {
                        minlength: 6,
                        maxlength: 255
                    },
                    nidn_user: {
                        minlength: 3,
                        maxlength: 20
                    },
                    gelar_akademik: {
                        minlength: 2,
                        maxlength: 50
                    },
                    email_user: {
                        required: true,
                        email: true
                    },
                    foto: {
                        accept: "png,jpg,jpeg"
                    }
                },
                submitHandler: function(form) {
                    var formData = new FormData(form);
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire('Berhasil', response.message, 'success');
                                tableUser.ajax.reload();
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire('Kesalahan', response.message, 'error');
                            }
                        }
                    });
                    return false;
                }
            });

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
        </script>
    @endempty
