<form action="{{ url('/prodi/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Prodi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <div class="form-group">
                    <label>Nama User</label>
                    <select class="form-control" id="id_user" name="id_user" required>
                        <option value="">- Pilih user -</option>
                        @foreach ($user as $c)
                            <option value="{{ $c->id_user }}">{{ $c->nama_user }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_user" class="error-text form-text text-danger"></small>
                </div>     --}}
                <div class="form-group">
                    <label>Kode Prodi</label>
                    <input type="text" name="kode_prodi" id="kode_prodi" class="form-control" required>
                    <small id="error-kode_prodi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nama Prodi</label>
                    <input type="text" name="nama_prodi" id="nama_prodi" class="form-control" required>
                    <small id="error-nama_prodi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Jenjang</label>
                    <select class="form-control" id="jenjang" name="jenjang" required>
                        <option value="">-- Pilih Jenjang --</option>
                        <option value="D2">D2</option>
                        <option value="D4">D4</option>
                        <option value="S2">S2</option>
                    </select>
                    <small id="jenjang" class="jenjang"></small>
                </div> 

                {{-- <div class="form-group">
                    <label>NIDN User</label>
                    <input type="text" name="nidn_user" id="nidn_user" class="form-control" required>
                    <small id="error-nidn_user" class="error-text form-text text-danger"></small>
                </div> --}}

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
                // id_user: {
                //     required: true,
                //     number: true
                // },
                kode_prodi: {
                    required: true, // Pastikan field Prodi wajib diisi
                    maxlength: 100, // Maksimal panjang karakter
                },
                nama_prodi: {
                    required: true,
                    maxlength: 100,
                },
                jenjang: {
                    required: true,
                },  
                // nidn_user: {
                //     required: true,
                //     minlength: 3,
                //     maxlength: 20,
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
