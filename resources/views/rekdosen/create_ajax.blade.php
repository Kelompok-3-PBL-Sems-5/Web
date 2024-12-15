<form action="{{ url('/notifikasi/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Rekomendasi Dosen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                
                <div class="form-group">
                    <label>Nama User</label>
                    <select class="form-control" id="id_user" name="id_user" required>
                        <option value="">- Pilih user -</option>
                        @foreach ($user as $c)
                            <option value="{{ $c->id_user }}">{{ $c->nama_user }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_user" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Nama Program</label>
                    <select class="form-control" id="id_vendor" name="id_vendor" required>
                        <option value="">- Pilih Vendor -</option>
                        @foreach ($vendor as $a)
                            <option value="{{ $a->id_vendor }}">{{ $a->nama_vendor }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_vendor" class="error-text form-text text-danger"></small>
                </div>
                             
                <div class="form-group">
                    <label>Tautan Bukti Sertifikasi</label>
                    <input value="" type="text" name="bukti_sertif" id="bukti_sertif" class="form-control" required>
                    <small id="error-bukti_sertif" class="error-text form-text text-danger"></small>
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
                id_user: {
                    required: true,
                    number: true
                },
                id_vendor: {
                    required: true,
                    number: true
                },
                id_damat: {
                    required: true,
                    number: true
                },
                id_dabim: {
                    required: true,
                    number: true
                },
                nama_sertif: {
                    required: true,
                    minlength: 3
                },
                jenis_sertif: {
                    required: true,
                },
                tgl_mulai_sertif: {
                    required: true,
                    date: true
                },
                tgl_akhir_sertif: {
                    required: true,
                    date: true
                },
                jenis_pendanaan_sertif: {
                    required: true,
                },
                bukti_sertif: {
                    required: true
                },
                status: {
                    required: true
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
                            datasertifikasi.ajax.reload();
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