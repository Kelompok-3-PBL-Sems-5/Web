@empty($pengajuan_sertifikasi)
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
                <a href="{{ url('/ajukan_sertifikasi') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/ajukan_sertifikasi/' . $pengajuan_sertifikasi->id_pengsertifikasi . '/delete_ajax') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Pengajuan Sertifikasi</h5>
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
                            <td class="col-9">{{ $pengajuan_sertifikasi->user->nama_user }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama Vendor :</th>
                            <td class="col-9">{{ $pengajuan_sertifikasi->vendor->nama_vendor }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Judul Sertifikasi :</th>
                            <td class="col-9">{{ $pengajuan_sertifikasi->judul }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Tujuan :</th>
                            <td class="col-9">{{ $pengajuan_sertifikasi->tujuan }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Relevansi dengan Tugas Akademik :</th>
                            <td class="col-9">{{ $pengajuan_sertifikasi->relevansi }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Tanggal Pelaksanaan :</th>
                            <td class="col-9">{{ $pengajuan_sertifikasi->tanggal }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Lokasi (Online/Offline) :</th>
                            <td class="col-9">{{ $pengajuan_sertifikasi->lokasi }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Biaya :</th>
                            <td class="col-9">{{ $pengajuan_sertifikasi->biaya }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Sumber Dana :</th>
                            <td class="col-9">{{ $pengajuan_sertifikasi->dana }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Rencana Implementasi :</th>
                            <td class="col-9">{{ $pengajuan_sertifikasi->implementasi }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Link Informasi Resmi :</th>
                            <td class="col-9">{{ $pengajuan_sertifikasi->link }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Status :</th>
                            <td class="col-9">{{ $pengajuan_sertifikasi->status }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Komentar Pimjur :</th>
                            <td class="col-9">{{ $pengajuan_sertifikasi->komentar }}</td>
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
@endempty