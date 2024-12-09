@empty($bidang_minat)
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
                    <a href="{{ url('/bidang_minat') }}" class="btn btn-warning">Kembali</a>
                </div>
            </div>
        </div>
    @else
        <form action="{{ url('/bidang_minat/' . $bidang_minat->id_bidang_minat . '/update_ajax') }}" method="POST" id="form-edit">
            @csrf
            @method('PUT')
            <div id="modal-master" class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Data Bidang Minat</h5>
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
                                        <option {{ $item->id_user == $bidang_minat->id_user ? 'selected' : '' }}
                                            value="{{ $item->id_user }}">{{ $item->nama_user }}</option>
                                    @endforeach
                                </select>
                                <small id="error-id_user" class="error-text form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 control-label col-form-label">Bidang Minat</label>
                            <div class="col-10">
                                <select class="form-control" name="bidang_minat" id="bidang_minat" required>
                                    <option value="">- Pilih bidang minat -</option>
                                    <option value="Data Science" {{ $bidang_minat->bidang_minat == 'Data Science' ? 'selected' : '' }}>Data Science</option>
                                    <option value="Web Development" {{ $bidang_minat->bidang_minat == 'Web Development' ? 'selected' : '' }}>Web Development</option>
                                    <option value="Jaringan" {{ $bidang_minat->bidang_minat == 'Jaringan' ? 'selected' : '' }}>Jaringan</option>
                                    <option value="Keamanan (Keamanan Siber)" {{ $bidang_minat->bidang_minat == 'Keamanan (Keamanan Siber)' ? 'selected' : '' }}>Keamanan (Keamanan Siber)</option>
                                    <option value="Mobile Development" {{ $bidang_minat->bidang_minat == 'Mobile Development' ? 'selected' : '' }}>Mobile Development</option>
                                    <option value="Cloud Computing" {{ $bidang_minat->bidang_minat == 'Cloud Computing' ? 'selected' : '' }}>Cloud Computing</option>
                                    <option value="Internet of Things (IoT)" {{ $bidang_minat->bidang_minat == 'Internet of Things (IoT)' ? 'selected' : '' }}>Internet of Things (IoT)</option>
                                    <option value="Blockchain" {{ $bidang_minat->bidang_minat == 'Blockchain' ? 'selected' : '' }}>Blockchain</option>
                                    <option value="UI/UX Design" {{ $bidang_minat->bidang_minat == 'UI/UX Design' ? 'selected' : '' }}>UI/UX Design</option>
                                    <option value="Manajemen TI" {{ $bidang_minat->bidang_minat == 'Manajemen TI' ? 'selected' : '' }}>Manajemen TI</option>
                                </select>
                                <small id="error-bidang_minat" class="error-text form-text text-danger"></small>
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
                        bidang_minat: {
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
                                    databidang_minat.ajax.reload();
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