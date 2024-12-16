<form action="{{ url('/data_pelatihan/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data pelatihan</h5>
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
                    <label>Nama Mata Kuliah</label>
                    <select class="form-control" id="id_damat" name="id_damat" required>
                        <option value="">- Pilih Mata Kuliah -</option>
                        @foreach ($damat as $a)
                            <option value="{{ $a->id_damat }}">{{ $a->nama_damat }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_damat" class="error-text form-text text-danger"></small>
                </div>
                
                <div class="form-group">
                    <label>Nama Bidang Minat</label>
                    <select class="form-control" id="id_dabim" name="id_dabim" required>
                        <option value="">- Pilih Bidang Minat -</option>
                        @foreach ($dabim as $a)
                            <option value="{{ $a->id_dabim }}">{{ $a->nama_dabim }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_dabim" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nama Pelatihan</label>
                    <input value="" type="text" name="nama_pelatihan" id="nama_pelatihan" class="form-control" required>
                    <small id="error-nama_pelatihan" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Jenis Pelatihan</label>
                    <select class="form-control" id="id_jenpel" name="id_jenpel" required>
                        <option value="">- Pilih Jenis Pelatihan -</option>
                        @foreach ($jenis_pelatihan as $a)
                            <option value="{{ $a->id_jenpel }}">{{ $a->nama_jenpel }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_jenpel" class="error-text form-text text-danger"></small>
                </div>  
                <div class="form-group">
                    <label>Tanggal Mulai Pelatihan</label>
                    <input value="" type="date" name="tgl_mulai" id="tgl_mulai" class="form-control" required>
                    <small id="error-tgl_mulai" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Tanggal Akhir Pelatihan</label>
                    <input value="" type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" required>
                    <small id="error-tgl_akhir" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Level Pelatihan</label>
                    <select class="form-control" id="level_pelatihan" name="level_pelatihan" required>
                        <option value="">-- Pilih Level Pelatihan --</option>
                        <option value="Nasional">Nasional</option>
                        <option value="Internasional">Internasional</option>
                    </select>
                    <small id="error-level_pelatihan" class="error-text form-text text-danger"></small>
                </div> 
                <div class="form-group">
                    <label>Jenis Pendanaan</label>
                    <select class="form-control" id="jenis_pendanaan" name="jenis_pendanaan" required>
                        <option value="">-- Pilih Jenis Pendanaan --</option>
                        <option value="Mandiri">Mandiri</option>
                        <option value="Eksternal">Eksternal</option>
                    </select>
                    <small id="error-jenis_pendanaan" class="error-text form-text text-danger"></small>
                </div>                
                <div class="form-group">
                    <label>Tautan Bukti Pelatihan</label>
                    <input value="" type="text" name="bukti_pelatihan" id="bukti_pelatihan" class="form-control">
                    <small id="error-bukti_pelatihan" class="error-text form-text text-danger"></small>
                </div>
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
                nama_pelatihan: {
                    required: true,
                    minlength: 3
                },
                jenis_pelatihan: {
                    required: true,
                },
                tgl_mulai: {
                    required: true,
                    date: true
                },
                tgl_akhir: {
                    required: true,
                    date: true
                },
                level_pelatihan: {
                    required: true,
                },
                jenis_pendanaan: {
                    required: true,
                },
                bukti_pelatihan: {
                    required: false
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
                            datapelatihan.ajax.reload();
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