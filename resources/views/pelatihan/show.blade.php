@empty($pelatihan)
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
                <a href="{{ url('/data_pelatihan') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail data Pelatihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>No</th>
                        <td>{{ $pelatihan->id_pelatihan }}</td>
                    </tr>
                    <tr>
                        <th>Nama User</th>
                        <td>{{ $pelatihan->user->nama_user }}</td>
                    </tr>
                    <tr>
                        <th>Nama Vendor</th>
                        <td>{{ $pelatihan->vendor->nama_vendor }}</td>
                    </tr>
                    <tr>
                        <th>Nama Mata Kuliah</th>
                        <td>{{ $pelatihan->matkul->nama_matkul }}</td>
                    </tr>
                    <tr>
                        <th>Nama Bidang Minat</th>
                        <td>{{ $pelatihan->bidang_minat->bidang_minat }}</td>
                    </tr>
                    <tr>
                        <th>Nama Pelatihan</th>
                        <td>{{ $pelatihan->nama_pelatihan }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Pelatihan</th>
                        <td>{{ $pelatihan->jenis_pelatihan }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Mulai Pelatihan</th>
                        <td>{{ $pelatihan->tgl_mulai }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Akhir Pelatihan</th>
                        <td>{{ $pelatihan->tgl_akhir }}</td>
                    </tr>
                    <tr>
                        <th>Level Pelatihan</th>
                        <td>{{ $pelatihan->level_pelatihan }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Pendanaan</th>
                        <td>{{ $pelatihan->jenis_pendanaan }}</td>
                    </tr>
                    <tr>
                        <th>Tautan Bukti Pelatihan</th>
                        <td>
                            @if($pelatihan->bukti_pelatihan)
                                <a href="{{ $pelatihan->bukti_pelatihan }}" target="_blank">Lihat Bukti</a>
                            @else
                                Bukti Tidak Tersedia
                            @endif
                        </td>
                    </tr> 
                    <tr>
                        <th>Status Pelatihan</th>
                        <td>{{ $pelatihan->status }}</td>
                    </tr>                    
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Kembali</button>
            </div>
        </div>
    </div>
@endempty