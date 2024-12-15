@empty($user)
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
                    Data yang Anda cari tidak ditemukan
                </div>
                <a href="{{ url('/user') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Foto Profil -->
                        <div class="col-md-4 text-center">
                            @if ($user->image_profile != "")
                                <img id="profile-picture" src="{{ asset('storage/' . $user->image_profile) }}"
                                    alt="Profile Picture" class="img-fluid rounded-circle border shadow-sm w-75 h-75 mb-3">
                            @else
                                <img id="profile-picture" src="{{ asset('img/default-profile.png') }}"
                                    alt="Default Profile" class="img-fluid rounded-circle border shadow-sm w-75 h-75 mb-3">
                                <small class="text-muted">Tidak ada foto profil</small>
                            @endif
                        </div>
                        
                        <!-- Detail Informasi -->
                        <div class="col-md-8">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $user->user_id }}</td>
                                </tr>
                                <tr>
                                    <th>Level</th>
                                    <td>{{ $user->level->level_nama }}</td>
                                </tr>
                                <tr>
                                    <th>Username</th>
                                    <td>{{ $user->username }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>NIDN</th>
                                    <td>{{ $user->nidn_user ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Gelar Akademik</th>
                                    <td>{{ $user->gelar_akademik ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Password</th>
                                    <td>********</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Kembali</button>
            </div>
        </div>
    </div>
@endempty
