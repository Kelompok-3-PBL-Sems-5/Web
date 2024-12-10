@empty($pelatihan)
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
                    <a href="{{ url('/data_pelatihan') }}" class="btn btn-warning">Kembali</a>
                </div>
            </div>
        </div>
    @else
        <form action="{{ url('/data_pelatihan/' . $pelatihan->id_pelatihan . '/update_ajax') }}" method="POST" id="form-edit">
            @csrf
            @method('PUT')
            <div id="modal-master" class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Data Pelatihan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body">

                            <div class="form-group row">
                                <label class="col-2 control-label col-form-label">Nama User</label>
                                <div class="col-10">
                                    <select class="form-control" id="id_user" name="id_user" required>
                                        <option value="">- Pilih user -</option>
                                        @foreach ($user as $item)
                                            <option {{ $item->id_user == $pelatihan->id_user ? 'selected' : '' }}
                                                value="{{ $item->id_user }}">{{ $item->nama_user }}</option>
                                        @endforeach
                                    </select>
                                    <small id="error-id_user" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-2 control-label col-form-label">Nama Vendor</label>
                                <div class="col-10">
                                    <select class="form-control" id="id_vendor" name="id_vendor" required>
                                        <option value="">- Pilih vendor -</option>
                                        @foreach ($vendor as $item)
                                            <option {{ $item->id_vendor == $pelatihan->id_vendor ? 'selected' : '' }}
                                                value="{{ $item->id_vendor }}">{{ $item->nama_vendor }}</option>
                                        @endforeach
                                    </select>
                                    <small id="error-id_vendor" class="error-text form-text text-danger"></small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-2 control-label col-form-label">Nama Mata Kuliah</label>
                                <div class="col-10">
                                    <select class="form-control" id="id_matkul" name="id_matkul" required>
                                        <option value="">- Pilih Mata Kuliah -</option>
                                        @foreach ($matkul as $item)
                                            <option {{ $item->id_matkul == $pelatihan->id_matkul ? 'selected' : '' }}
                                                value="{{ $item->id_matkul }}">{{ $item->nama_matkul }}</option>
                                        @endforeach
                                    </select>
                                    <small id="error-id_matkul" class="error-text form-text text-danger"></small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-2 control-label col-form-label">Nama Bidang Minat</label>
                                <div class="col-10">
                                    <select class="form-control" id="id_bidang_minat" name="id_bidang_minat" required>
                                        <option value="">- Pilih Bidang Minat -</option>
                                        @foreach ($bidang_minat as $item)
                                            <option {{ $item->id_bidang_minat == $pelatihan->id_bidang_minat ? 'selected' : '' }}
                                                value="{{ $item->id_bidang_minat }}">{{ $item->bidang_minat }}</option>
                                        @endforeach
                                    </select>
                                    <small id="error-id_bidang_minat" class="error-text form-text text-danger"></small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-2 control-label col-form-label">Nama Pelatihan</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="nama_pelatihan" name="nama_pelatihan"
                                        value="{{ $pelatihan->nama_pelatihan }}" required>
                                    <small id="error-nama_pelatihan" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-2 control-label col-form-label">Jenis Pelatihan</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="jenis_pelatihan" name="jenis_pelatihan"
                                        value="{{ $pelatihan->jenis_pelatihan }}" required>
                                    <small id="error-jenis_pelatihan" class="error-text form-text text-danger"></small>
                                </div>
                            </div>   
                            <div class="form-group row">
                                <label class="col-2 control-label col-form-label">Tanggal Mulai</label>
                                <div class="col-10">
                                    <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai"
                                        value="{{ $pelatihan->tgl_mulai }}" required>
                                    <small id="error-tgl_mulai" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-2 control-label col-form-label">Tanggal Akhir</label>
                                <div class="col-10">
                                    <input type="date" class="form-control" id="tgl_akhir" name="tgl_akhir"
                                        value="{{ $pelatihan->tgl_akhir }}" required>
                                    <small id="error-tgl_akhir" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-2 control-label col-form-label">Level Pelatihan</label>
                                <div class="col-10">
                                    <select class="form-control" id="level_pelatihan" name="level_pelatihan" required>
                                        <option value="">- Pilih Level Pelatihan -</option>
                                        <option value="Nasional" {{ old('level_pelatihan', $pelatihan->level_pelatihan) == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                        <option value="Internasional" {{ old('level_pelatihan', $pelatihan->level_pelatihan) == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                                    </select>
                                    <small id="error-level_pelatihan" class="error-text form-text text-danger"></small>
                                </div>
                            </div>           
                            <div class="form-group row">
                                <label class="col-2 control-label col-form-label">Jenis Pendanaan</label>
                                <div class="col-10">
                                    <select class="form-control" id="jenis_pendanaan" name="jenis_pendanaan" required>
                                        <option value="">- Pilih Jenis Pendanaan -</option>
                                        <option value="Mandiri" {{ old('jenis_pendanaan', $pelatihan->jenis_pendanaan) == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                                        <option value="Eksternal" {{ old('jenis_pendanaan', $pelatihan->jenis_pendanaan) == 'Eksternal' ? 'selected' : '' }}>Eksternal</option>
                                    </select>
                                    <small id="error-jenis_pendanaan" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-2 control-label col-form-label"> Tautan Bukti Pelatihan</label>
                                <div class="col-10">
                                    <input value="{{ $pelatihan->bukti_pelatihan}}" type="text" name="bukti_pelatihan" id="bukti_pelatihan"
                                    class="form-control" required>
                                    <small id="error-bukti_pelatihan" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                            {{-- <div class="form-group row">
                                <label class="col-2 control-label col-form-label">Status</label>
                                <div class="col-10">
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="">- Pilih Status -</option>
                                        <option value="Aktif">Aktif</option>
                                        <option value="Selesai">Selesai</option>
                                    </select>
                                    <small id="error-status" class="error-text form-text text-danger"></small>
                                </div>
                            </div> --}}
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
                        id_vendor: {
                            required: true,
                            number: true
                        },
                        id_matkul: {
                            required: true,
                            number: true
                        },
                        id_bidang_minat: {
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
    @endempty