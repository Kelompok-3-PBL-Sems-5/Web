<form action="{{ url('/matkul/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Mata Kuliah</h5>
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
                    <label>Nama Mata Kuliah</label>
                    <select class="form-control" id="id_damat" name="id_damat" required>
                        <option value="">- Pilih  Mata Kuliah -</option>
                        @foreach ($damat as $c)
                            <option value="{{ $c->id_damat }}">{{ $c->nama_damat }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_damat" class="error-text form-text text-danger"></small>
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
                id_damat: {
                    required: true,
                    number: true
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
                            datamatkul.ajax.reload();
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