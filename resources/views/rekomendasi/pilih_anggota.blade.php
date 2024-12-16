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
    <form action="{{ url('/rekomendasi/' . $rekomendasi->id_program . '/update_ajax') }}" method="POST" id="form-edit">
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

                    <div id="anggota-container">
                        <div class="form-group anggota-item">
                            <label>Nama Anggota</label>
                            <div class="input-group">
                                <select class="form-control" name="id_user[]" required>
                                    <option value="">- Pilih user -</option>
                                    @foreach ($user as $a)
                                        <option value="{{ $a->id_user }}">
                                            {{ $a->nama_user }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-success add-anggota">+</button>
                                </div>
                            </div>
                            <small class="error-text form-text text-danger"></small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function () {
            // Event listener to add a new anggota field
            $(document).on('click', '.add-anggota', function () {
                const newField = `
                    <div class="form-group anggota-item">
                        <label>Nama Anggota</label>
                        <div class="input-group">
                            <select class="form-control" name="id_user[]" required>
                                <option value="">- Pilih user -</option>
                                @foreach ($user as $a)
                                    <option value="{{ $a->id_user }}">
                                        {{ $a->nama_user }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-danger remove-anggota">&times;</button>
                            </div>
                        </div>
                        <small class="error-text form-text text-danger"></small>
                    </div>
                `;
                $('#anggota-container').append(newField);
            });

            // Event listener to remove an anggota field
            $(document).on('click', '.remove-anggota', function () {
                $(this).closest('.anggota-item').remove();
            });

            // Form validation and submission
            $("#form-edit").validate({
                rules: {
                    "id_user[]": { required: true }
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function (response) {
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
                                $.each(response.msgField, function (prefix, val) {
                                    $(`#error-${prefix}`).text(val[0]);
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
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endempty