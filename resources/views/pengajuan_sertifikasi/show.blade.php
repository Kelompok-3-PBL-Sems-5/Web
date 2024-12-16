@empty($pengajuan_sertifikasi)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria label="Close"><span
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
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail data Pengajuan Sertifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>No</th>
                        <td>{{ $pengajuan_sertifikasi->id_pengsertifikasi }}</td>
                    </tr>
                    <tr>
                        <th>Nama User</th>
                        <td>{{ $pengajuan_sertifikasi->user->nama_user }}</td>
                    </tr>
                    <tr>
                        <th>Nama Vendor</th>
                        <td>{{ $pengajuan_sertifikasi->vendor->nama_vendor }}</td>
                    </tr>
                    <tr>
                        <th>Judul Sertifikasi</th>
                        <td>{{ $pengajuan_sertifikasi->judul }}</td>
                    </tr>
                    <tr>
                        <th>Tujuan</th>
                        <td>{{ $pengajuan_sertifikasi->tujuan }}</td>
                    </tr>
                    <tr>
                        <th>Relevansi dengan Tugas Akademik</th>
                        <td>{{ $pengajuan_sertifikasi->relevansi }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Pelaksanaan</th>
                        <td>{{ $pengajuan_sertifikasi->tanggal }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi (Online/Offline)</th>
                        <td>{{ $pengajuan_sertifikasi->lokasi }}</td>
                    </tr>
                    <tr>
                        <th>Biaya</th>
                        <td>{{ $pengajuan_sertifikasi->biaya }}</td>
                    </tr>
                    <tr>
                        <th>Sumber Dana</th>
                        <td>{{ $pengajuan_sertifikasi->dana }}</td>
                    </tr>
                    <tr>
                        <th>Rencana Implementasi</th>
                        <td>{{ $pengajuan_sertifikasi->implementasi }}</td>
                    </tr>
                    <tr>
                        <th>Link Informasi Resmi</th>
                        <td>{{ $pengajuan_sertifikasi->link }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $pengajuan_sertifikasi->status }}</td>
                    </tr>
                    <tr>
                        <th>Komentar Pimjur</th>
                        <td>{{ $pengajuan_sertifikasi->komentar }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Kembali</button>
            </div>
        </div>
    </div>
@endempty