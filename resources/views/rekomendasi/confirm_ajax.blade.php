@empty($rekomendasi)
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
                <a href="{{ url('/rekomendasi') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/rekomendasi/' . $program->id_program . '/delete_ajax') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data rekomendasi</h5>
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
                            <th class="text-right col-3">Nama Vendor:</th>
                            <td class="col-9">{{ $rekomendasi->vendor->nama_vendor }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Jenis Program  :</th>
                            <td class="col-9">{{ $rekomendasi->jenis_program }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama Program  :</th>
                            <td class="col-9">{{ $rekomendasi->nama_program  }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama Matkul :</th>
                            <td class="col-9">{{ $rekomendasi->matkul->nama_matkul }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama Bidang Minat :</th>
                            <td class="col-9">{{ $rekomendasi->bidang_minat->bidang_minat }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Level Program :</th>
                            <td class="col-9">{{ $rekomendasi->level_program }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Kuota Program :</th>
                            <td class="col-9">{{ $rekomendasi->kuota_program }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Jenis Pendanaan :</th>
                            <td class="col-9">{{ $rekomendasi->jenis_pendanaan_sertif }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Status :</th>
                            <td class="col-9">{{ $rekomendasi->status }}</td>
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