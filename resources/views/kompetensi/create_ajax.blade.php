<form action="{{ url('/kompetensi/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Kompetensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label>Nama Prodi</label>
                    <select class="form-control" id="id_prodi" name="id_prodi" required>
                        <option value="">- Pilih prodi -</option>
                        @foreach ($prodi as $c)
                            <option value="{{ $c->id_prodi }}">{{ $c->nama_prodi }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_prodi" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Nama Kompetensi</label>
                    <input type="text" name="nama_kompetensi" id="nama_kompetensi" class="form-control" placeholder="Masukkan nama kompetensi" required>
                    <small id="error-nama_kompetensi" class="error-text form-text text-danger"></small>
                </div>
                
                {{-- <div class="form-group"> 
                    <label>ID User</label>
                    <input type="text" name="ID_user" id="nama_user" class="form-control" required>
                    <small id="error-ID_user" class="error-text form-text text-danger"></small>
                </div> --}}
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
                id_prodi: {
                    required: true,
                    number: true
                },
                nama_kompetensi: {
                    required: true, // Pastikan field kompetensi wajib diisi
                    minlength: 3, // Minimal panjang karakter yang diizinkan
                    maxlength: 100 // Maksimal panjang karakter
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
                            dataKompetensi.ajax.reload();
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
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat mengirim data. Coba lagi nanti.'
                        });
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
