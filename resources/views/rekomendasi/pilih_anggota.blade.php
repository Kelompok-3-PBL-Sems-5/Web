@empty($rekomendasi)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan.
                </div>
                <a href="{{ url('/rekomendasi') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/rekomendasi/' . $rekomendasi->id_program . '/pilih_anggota') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group">
                        <h5 class="modal-title" id="exampleModalLabel">Pilih Anggota</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="form-group">
                        <label>Nama Vendor</label>
                        <select class="form-control" id="id_vendor" name="id_vendor" required>
                            <option value="">- Pilih Vendor -</option>
                            @foreach ($vendor as $a)
                                <option value="{{ $a->id_vendor }}" {{ $rekomendasi->id_vendor == $a->id_vendor ? 'selected' : '' }}>
                                    {{ $a->nama_vendor }}   
                                </option>
                            @endforeach
                        </select>
                        <small id="error-id_vendor" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Jenis Program</label>
                        <select class="form-control" id="jenis_program" name="jenis_program" required>
                            <option value="">-- Pilih Jenis Program --</option>
                            <option value="Sertifikasi" {{ $rekomendasi->jenis_program == 'Sertifikasi' ? 'selected' : '' }}>Sertifikasi</option>
                            <option value="Pelatihan" {{ $rekomendasi->jenis_program == 'Pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                        </select>
                        <small id="error-jenis_program" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Nama Program</label>
                        <input type="text" name="nama_program" id="nama_program" class="form-control" 
                               value="{{ $rekomendasi->nama_program }}" required>
                        <small id="error-nama_program" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Nama Mata Kuliah</label>
                        <select class="form-control" id="id_damat" name="id_damat" required>
                            <option value="">- Pilih Mata Kuliah -</option>
                            @foreach ($damat as $a)
                                <option value="{{ $a->id_damat }}" {{ $rekomendasi->id_damat == $a->id_damat ? 'selected' : '' }}>
                                    {{ $a->nama_damat }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-id_damat" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Nama Bidang Minat</label>
                        <select class="form-control" id="id_dabim" name="id_dabim" required>
                            <option value="">- Pilih Bidang Minat -</option>
                            @foreach ($dabim as $a)
                                <option value="{{ $a->id_dabim }}" {{ $rekomendasi->id_dabim == $a->id_dabim ? 'selected' : '' }}>
                                    {{ $a->nama_dabim }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-id_dabim" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Program</label>
                        <input type="date" name="tanggal_program" id="tanggal_program" class="form-control" 
                               value="{{ $rekomendasi->tanggal_program }}" required>
                        <small id="error-tanggal_program" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Level Program</label>
                        <select class="form-control" id="level_program" name="level_program" required>
                            <option value="">-- Pilih Level Program --</option>
                            <option value="Nasional" {{ $rekomendasi->level_program == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                            <option value="Internasional" {{ $rekomendasi->level_program == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                        </select>
                        <small id="error-level_program" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Kuota Program</label>
                        <input type="number" name="kuota_program" id="kuota_program" class="form-control" 
                               value="{{ $rekomendasi->kuota_program }}" required>
                        <small id="error-kuota_program" class="error-text form-text text-danger"></small>
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
                    id_vendor: { required: true },
                    jenis_program: { required: true },
                    nama_program: { required: true },
                    id_damat: { required: true },
                    id_dabim: { required: true },
                    tanggal_program: { required: true, date: true },
                    level_program: { required: true },
                    kuota_program: { required: true, number: true }
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
                                datarekomendasi.ajax.reload();
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
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endempty
