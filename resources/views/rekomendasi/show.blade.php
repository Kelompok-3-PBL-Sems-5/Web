@empty($rekomendasi)
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
                <a href="{{ url('/rekomendasi') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail data rekomendasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>No</th>
                        <td>{{ $rekomendasi->id_program }}</td>
                    </tr>
                    <tr>
                        <th>Nama Vendor</th>
                        <td>{{ $rekomendasi->vendor->nama_vendor }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Program</th>
                        <td>{{ $rekomendasi->jenis_program }}</td>
                    </tr>
                    <tr>
                        <th>Nama Program</th>
                        <td>{{ $rekomendasi->nama_program }}</td>
                    </tr>
                    <tr>
                        <th>Nama Mata Kuliah</th>
                        <td>{{ $rekomendasi->matkul->nama_matkul }}</td>
                    </tr>
                    <tr>
                        <th>Nama Bidang Minat</th>
                        <td>{{ $rekomendasi->bidang_minat->bidang_minat }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Program</th>
                        <td>{{ $rekomendasi->tanggal_program }}</td>
                    </tr>
                    <tr>
                        <th>Level Program</th>
                        <td>{{ $rekomendasi->level_program }}</td>
                    </tr>
                    <tr>
                        <th>Kuota Program</th>
                        <td>{{ $rekomendasi->kuota_program }}</td>
                    </tr>             
                    <tr>
                        <th>Status rekomendasi</th>
                        <td>{{ $rekomendasi->status }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Kembali</button>
            </div>
        </div>
    </div>
@endempty