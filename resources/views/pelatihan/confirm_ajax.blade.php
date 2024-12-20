@empty($pelatihan)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
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
    <form action="{{ url('/data_pelatihan/' . $pelatihan->id_pelatihan . '/delete_ajax') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data pelatihan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-ban"></i> Konfirmasi !!!</h5>
                        Apakah Anda ingin menghapus data seperti di bawah ini?
                    </div>
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">Nama User:</th>
                            <td class="col-9">{{ $pelatihan->user->nama_user }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama Vendor :</th>
                            <td class="col-9">{{ $pelatihan->vendor->nama_vendor }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama Mata Kuliah :</th>
                            <td class="col-9">{{ $pelatihan->damat->nama_damat }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama Bidang Minat :</th>
                            <td class="col-9">{{ $pelatihan->dabim->nama_dabim }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama Pelatihan :</th>
                            <td class="col-9">{{ $pelatihan->nama_pelatihan }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Jenis Pelatihan :</th>
                            <td class="col-9">{{ $pelatihan->jenis_pelatihan->nama_jenpel }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Tanggal Mulai :</th>
                            <td class="col-9">{{ $pelatihan->tgl_mulai }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Tanggal Akhir :</th>
                            <td class="col-9">{{ $pelatihan->tgl_akhir }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Level Pelatihan :</th>
                            <td class="col-9">{{ $pelatihan->level_pelatihan }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Jenis Pendanaan :</th>
                            <td class="col-9">{{ $pelatihan->jenis_pendanaan }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Tautan Bukti pelatihan :</th>
                            <td>
                                @if($pelatihan->bukti_pelatihan)
                                    <a href="{{ $pelatihan->bukti_pelatihan }}" target="_blank">Lihat Bukti</a>
                                @else
                                    Bukti Tidak Tersedia
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Status :</th>
                            <td class="col-9">{{ $pelatihan->status }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#form-delete").validate({
                rules: {},
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