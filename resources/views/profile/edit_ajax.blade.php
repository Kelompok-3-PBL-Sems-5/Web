@empty($user)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                        Data yang anda cari tidak ditemukan
                    </div>
                    <a href="{{ url('/profile') }}" class="btn btn-warning">Kembali</a>
                </div>
            </div>
        </div>
    @else
        <form action="{{ url('/profile/' . session('id_user') . '/update_ajax') }}" method="POST" id="form-edit"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div id="modal-master" class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Profile Anda</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Level Pengguna</label>
                            <select name="id_level" id="id_level" class="form-control" required>
                                <option value="">- Pilih Level -</option>
                                @foreach ($level as $l)
                                    <option {{ $l->id_level == $user->id_level ? 'selected' : '' }}
                                        value="{{ $l->id_level }}">{{ $l->nama_level }}</option>
                                @endforeach
                            </select>
                            <small id="error-id_level" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input value="{{ $user->nama_user }}" type="text" name="nama_user" id="nama_user"
                                class="form-control" required>
                            <small id="error-nama_user" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input value="{{ $user->username }}" type="text" name="username" id="username"
                                class="form-control" required>
                            <small id="error-username" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input value="" type="password" name="password" id="password" class="form-control">
                            <small class="form-text text-muted">Abaikan jika tidak ingin ubah
                                password</small>
                            <small id="error-password" class="error-text form-text text-danger"></small>
                        </div>

                            <!-- Data Tambahan -->
                            <div class="form-group">
                                <label>NIDN</label>
                                <input value="{{ $user->nidn_user }}" type="text" name="nidn_user" id="nidn_user" 
                                    class="form-control">
                                <small id="error-nidn_user" class="error-text form-text text-danger"></small>
                            </div>

                            <div class="form-group">
                                <label>Gelar Akademik</label>
                                <input value="{{ $user->gelar_akademik }}" type="text" name="gelar_akademik" id="gelar_akademik" 
                                    class="form-control">
                                <small id="error-gelar_akademik" class="error-text form-text text-danger"></small>
                            </div>
    
                        <div class="form-group">
                            <label>Email</label>
                            <textarea name="email_user" id="email_user" class="form-control">{{ $user->email_user ?? '' }}</textarea>
                            <small id="error-email_user" class="error-text form-text text-danger"></small>
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
                        nama_user: {
                            required: true,
                            minlength: 3,
                            maxlength: 100
                        },
                        username: {
                            required: true,
                            minlength: 3,
                            maxlength: 20
                        },
                        password: {
                            minlength: 6,
                            maxlength: 20
                        },
                        nidn_user: {
                            required: false,
                            minlength: 5,
                            maxlength: 255
                        },
                        gelar_akademik: {
                            required: false,
                            minlength: 5,
                            maxlength: 255
                        },
                        email_user: {
                            required: false,
                            minlength: 5,
                            maxlength: 255
                        }
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
                                    profile.ajax.reload();
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