<form action="{{ url('/rekomendasi/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data rekomendsai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
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
                    <label>Jenis Program</label>
                    <select class="form-control" id="jenis_program" name="jenis_program" required>
                        <option value="">-- Pilih Jenis Program --</option>
                        <option value="Sertifikasi">Sertifikasi</option>
                        <option value="Pelatihan">Pelatihan</option>
                    </select>
                <div class="form-group">
                    <label>Nama program</label>
                    <input value="" type="text" name="nama_program" id="nama_program" class="form-control" required>
                    <small id="error-nama_program" class="error-text form-text text-danger"></small>
                </div>             
                <div class="form-group">
                    <label>Nama Mata Kuliah</label>
                    <select class="form-control" id="id_matkul" name="id_matkul" required>
                        <option value="">- Pilih Mata Kuliah -</option>
                        @foreach ($matkul as $a)
                            <option value="{{ $a->id_matkul }}">{{ $a->nama_matkul }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_matkul" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nama Bidang Minat</label>
                    <select class="form-control" id="id_bidang_minat" name="id_bidang_minat" required>
                        <option value="">- Pilih Bidang Minat -</option>
                        @foreach ($bidang_minat as $a)
                            <option value="{{ $a->id_bidang_minat }}">{{ $a->bidang_minat }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_bidang_minat" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Tanggal Program</label>
                    <input value="" type="date" name="tanggal_program" id="tanggal_program" class="form-control" required>
                    <small id="error-tanggal_program" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Level Program</label>
                    <select class="form-control" id="level_program" name="level_program" required>
                        <option value="">-- Pilih Level Program --</option>
                        <option value="Nasional">Nasional</option>
                        <option value="Internasional">Internasional</option>
                    </select>
                    <small id="error-level_program" class="error-text form-text text-danger"></small>
                </div> 
                <div class="form-group">
                    <label>Kuota Program</label>
                    <input value="" type="text" name="kuota_program" id="kuota_program" class="form-control" required>
                    <small id="error-kuota_program" class="error-text form-text text-danger"></small>
                </div>
                {{-- <div class="form-group">
                    <label>Bukti rekomendsai</label>
                    <input value="" type="file" name="bukti_sertif" id="bukti_sertif" class="form-control" accept=".pdf,.jpg,.png" required>
                    <small class="form-text text-muted">Pilih file (PDF, JPG, PNG)</small>
                    <small id="error-bukti_sertif" class="error-text form-text text-danger"></small>
                </div> --}}
                {{-- <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                    <small id="error-status" class="error-text form-text text-danger"></small>
                </div> --}}
                
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
                id_vendor: {
                    required: true,
                    number: true
                },
                jenis_program: {
                    required: true,
                },
                nama_program: {
                    required: true,
                },
                id_matkul: {
                    required: true,
                },
                id_bidang_minat: {
                    required: true,
                },
                tanggal_program: {
                    required: true,
                    date: true
                },
                level_program: {
                    required: true,
                },
                kuota_program: {
                    required: true,
                },
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
                            datarekomendsai.ajax.reload();
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