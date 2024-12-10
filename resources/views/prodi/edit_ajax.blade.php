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
                        <div class="form-group row">
                            <label class="col-2 control-label col-form-label">Nama User</label>
                            <div class="col-10">
                                <select class="form-control" id="id_user" name="id_user" required>
                                    <option value="">- Pilih user -</option>
                                    @foreach ($user as $item)
                                        <option {{ $item->id_user == $prodi->id_user ? 'selected' : '' }}
                                            value="{{ $item->id_user }}">{{ $item->nama_user }}</option>
                                    @endforeach
                                </select>
                                <small id="error-id_user" class="error-text form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 control-label col-form-label">Kode Prodi</label>
                            <div class="col-10">
                                <input type="text" class="form-control" id="kode_prodi" name="kode_prodi"
                                    value="{{ $prodi->kode_prodi }}" required>
                                <small id="error-kode_prodi" class="error-text form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 control-label col-form-label">Nama Prodi</label>
                            <div class="col-10">
                                <input type="text" class="form-control" id="nama_prodi" name="nama_prodi"
                                    value="{{ $prodi->nama_prodi }}" required>
                                <small id="error-nama_prodi" class="error-text form-text text-danger"></small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-2 control-label col-form-label">Jenjang</label>
                            <div class="col-10">
                                <select class="form-control" name="jenjang" id="jenjang" required>
                                    <option value="">- Pilih Jenjang -</option>
                                    <option value="D4" {{ old('jenjang', $prodi->jenjang) == 'D4' ? 'selected' : '' }}>D4</option>
                                    <option value="S2" {{ old('jenjang', $prodi->jenjang) == 'S2' ? 'selected' : '' }}>S2</option>
                                </select>
                                <small id="error-jenjang" class="error-text form-text text-danger"></small>
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <label>NIDN User</label>
                            <input value="{{ $prodi->nidn_user }}" type="text" name="nidn_user" id="telp_user"
                                class="form-control" required>
                            <small id="error-nidn_user" class="error-text form-text text-danger"></small>
                        </div>    --}}
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
                kode_prodi: {
                    required: true,
                    maxlength: 100
                },
                nama_prodi: {
                    required: true,
                    maxlength: 100
                },
                jenjang: {
                    required: true,
                }
                // nidn_user: {
                //     required: true,
                //     minlength: 3,
                //     maxlength: 50
                // },
                
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