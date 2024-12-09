@empty($sertifikasi)
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
                <a href="{{ url('/data_sertifikasi') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail data Sertifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>No</th>
                        <td>{{ $sertifikasi->id_sertifikasi }}</td>
                    </tr>
                    <tr>
                        <th>Nama User</th>
                        <td>{{ $sertifikasi->user->nama_user }}</td>
                    </tr>
                    <tr>
                        <th>Nama Vendor</th>
                        <td>{{ $sertifikasi->vendor->nama_vendor }}</td>
                    </tr>
                    <tr>
                        <th>Nama Mata Kuliah</th>
                        <td>{{ $sertifikasi->matkul->nama_matkul }}</td>
                    </tr>
                    <tr>
                        <th>Nama Bidang Minat</th>
                        <td>{{ $sertifikasi->bidang_minat->bidang_minat }}</td>
                    </tr>
                    <tr>
                        <th>Nama Sertifikasi</th>
                        <td>{{ $sertifikasi->nama_sertif }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Sertifikasi</th>
                        <td>{{ $sertifikasi->jenis_sertif }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Mulai Sertifikasi</th>
                        <td>{{ $sertifikasi->tgl_mulai_sertif }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Akhir Sertifikasi</th>
                        <td>{{ $sertifikasi->tgl_akhir_sertif }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Pendanaan Sertifikasi</th>
                        <td>{{ $sertifikasi->jenis_pendanaan_sertif }}</td>
                    </tr>
                    <tr>
                        <th>Tautan Bukti Sertifikasi</th>
                        <td>
                            @if($sertifikasi->bukti_sertif)
                                <a href="{{ $sertifikasi->bukti_sertif }}" target="_blank">Lihat Bukti</a>
                            @else
                                Bukti Tidak Tersedia
                            @endif
                        </td>
                    </tr>                    
                    <tr>
                        <th>Status Sertifikasi</th>
                        <td>{{ $sertifikasi->status }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Kembali</button>
            </div>
        </div>
    </div>
@endempty