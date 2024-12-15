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
    </div>
@else
    <form action="{{ url('/matkul/' . $matkul->id_matkul . '/update_ajax') }}" method="POST" id="form-edit"
        enctype="multipart/form-data">
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
                    <div class="form-group">
                        <label>Kode Mata Kuliah</label>
                        <input value="{{ $matkul->kode_matkul }}" type="text" name="kode_matkul" id="kode_matkul"
                            class="form-control" required>
                        <small id="error-kode_matkul" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Nama Mata Kuliah</label>
                        <input value="{{ $matkul->nama_matkul }}" type="text" name="nama_matkul" id="nama_matkul"
                            class="form-control" required>
                        <small id="error-nama_matkul" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Pengajar (User)</label>
                        <select name="id_user" id="id_user" class="form-control" required>
                            <option value="">- Pilih Pengajar -</option>
                            @foreach ($users as $user)
                                <option {{ $user->id == $matkul->id_user ? 'selected' : '' }}
                                    value="{{ $user->id }}">{{ $user->nama }}</option>
                            @endforeach
                        </select>
                        <small id="error-id_user" class="error-text form-text text-danger"></small>
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
                    kode_matkul: {
                        required: true,
                        minlength: 3,
                        maxlength: 20
                    },
                    nama_matkul: {
                        required: true,
                        minlength: 3,
                        maxlength: 100
                    },
                    id_user: {
                        required: true,
                        number: true
                    },
                },
                submitHandler: function(form) {
                    var formData = new FormData(form);
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: formData,
                        processData: false, // Untuk menghandle file upload
                        contentType: false,
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                tableMatkul.ajax.reload();
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
