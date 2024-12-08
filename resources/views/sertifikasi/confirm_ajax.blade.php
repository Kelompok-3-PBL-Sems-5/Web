@empty($sertifikasi)
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
                <a href="{{ url('/data_sertifikasi') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/data_sertifikasi/' . $sertifikasi->id_sertifikasi . '/delete_ajax') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data sertifikasi</h5>
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
                            <td class="col-9">{{ $sertifikasi->user->nama_user }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama Vendor :</th>
                            <td class="col-9">{{ $sertifikasi->vendor->nama_vendor }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama Mata Kuliah :</th>
                            <td class="col-9">{{ $sertifikasi->matkul->nama_matkul }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama Bidang Minat :</th>
                            <td class="col-9">{{ $sertifikasi->bidang_minat->bidang_minat }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama Sertifikasi :</th>
                            <td class="col-9">{{ $sertifikasi->nama_sertif }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Jenis Sertifikasi :</th>
                            <td class="col-9">{{ $sertifikasi->jenis_sertif }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Tanggal Mulai :</th>
                            <td class="col-9">{{ $sertifikasi->tgl_mulai_sertif }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Tanggal Akhir :</th>
                            <td class="col-9">{{ $sertifikasi->tgl_akhir_sertif }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Jenis Pendanaan :</th>
                            <td class="col-9">{{ $sertifikasi->jenis_pendanaan_sertif }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Tautan Bukti Sertifikasi :</th>
                            <td>
                                @if($sertifikasi->bukti_sertif)
                                    <a href="{{ $sertifikasi->bukti_sertif }}" target="_blank">Lihat Bukti</a>
                                @else
                                    Bukti Tidak Tersedia
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Status :</th>
                            <td class="col-9">{{ $sertifikasi->status }}</td>
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
@endempty