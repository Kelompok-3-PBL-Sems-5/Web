<form action="{{ url('/ajukan_sertifikasi/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pengajuan Sertifikasi</h5>
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
                    <label>Nama Vendor</label>
                    <select class="form-control" id="id_vendor" name="id_vendor" required>
                        <option value="">- Pilih Vendor -</option>
                        @foreach ($vendor as $a)
                            <option value="{{ $a->id_vendor }}">{{ $a->nama_vendor }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_vendor" class="error-text form-text text-danger"></small>
                </div>              

                <div class="form-group">
                    <label>Judul Sertifikasi</label>
                    <input value="" type="text" name="judul" id="judul" class="form-control" required>
                    <small id="error-judul" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Tujuan</label>
                    <input value="" type="text" name="tujuan" id="tujuan" class="form-control" required>
                    <small id="error-tujuan" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Relevansi dengan Tugas Akademik</label>
                    <input value="" type="text" name="relevansi" id="relevansi" class="form-control" required>
                    <small id="error-relevansi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Tanggal Pelaksanaan</label>
                    <input value="" type="date" name="tanggal" id="tanggal" class="form-control" required>
                    <small id="error-tanggal" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Lokasi (Online/Offline)</label>
                    <select class="form-control" name="lokasi" id="lokasi" required>
                        <option value="">-- Pilih Lokasi --</option>
                        <option value="Online">Online</option>
                        <option value="Offline">Offline</option>
                    </select>
                    <small id="error-lokasi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Biaya</label>
                    <input value="" type="number" name="biaya" id="biaya" class="form-control" required>
                    <small id="error-biaya" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Sumber Dana</label>
                    <input value="" type="text" name="dana" id="dana" class="form-control" required>
                    <small id="error-dana" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Rencana Implementasi</label>
                    <input value="" type="text" name="implementasi" id="implementasi" class="form-control" required>
                    <small id="error-implementasi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Link Informasi Resmi</label>
                    <input value="" type="url" name="link" id="link" class="form-control" required>
                    <small id="error-link" class="error-text form-text text-danger"></small>
                </div>
                {{-- <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status" id="status" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="Terkirim" {{ $pengajuan_sertifikasi->status == 'Terkirim' ? 'selected' : '' }}>Terkirim</option>
                        <option value="Disetujui" {{ $pengajuan_sertifikasi->status == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="Ditolak" {{ $pengajuan_sertifikasi->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    <small id="error-status" class="error-text form-text text-danger"></small>
                </div> --}}
                <div class="form-group">
                    <label>Komentar Pimjur</label>
                    <input value="" type="text" name="komentar" id="komentar" class="form-control">
                    <small id="error-komentar" class="error-text form-text text-danger"></small>
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
                judul: {
                required: true,
                minlength: 3
                },
                tujuan: {
                    required: true,
                    minlength: 3
                },
                relevansi: {
                    required: true,
                    minlength: 3
                },
                tanggal: {
                    required: true,
                    date: true
                },
                lokasi: {
                    required: true
                },
                biaya: {
                    required: true,
                    number: true
                },
                dana: {
                    required: true,
                    minlength: 3
                },
                implementasi: {
                    required: true,
                    minlength: 3
                },
                link: {
                    required: false,
                    url: true
                },
                status: {
                    required: false
                },
                komentar: {
                    required: false,
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
                            datapengajuan_sertifikasi.ajax.reload();
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