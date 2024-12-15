{{-- <!-- Navbar HTML -->
<nav class="mb-70 navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('images/logo.png') }}" height="48" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <!-- Beranda -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('index') }}">Beranda</a>
                </li>
                
                <!-- Fitur Utama -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('halaman_dosen*') ? 'active' : '' }}" href="{{ route('landing.halaman_dosen') }}">Halaman Dosen</a>
                </li>

                <!-- Keuntungan -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('d_sertifikasi*') ? 'active' : '' }}" href="{{ route('landing.d_sertifikasi') }}">Daftar Sertifikasi</a>
                </li>

                <!-- Daftar Pelatihan -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('d_pelatihan*') ? 'active' : '' }}" href="{{ route('landing.d_pelatihan') }}">Daftar Pelatihan</a>
                </li>
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="btn btn-secondary" href="#">Log In</a>
                </li>
            </ul>
        </div>
    </div>
</nav> --}}


<!-- Navbar HTML -->
<nav class="mb-70 navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('images/logo.png') }}" height="48" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <!-- Beranda -->
                <li class="nav-item">
                    <a class="nav-link" href="#header">Beranda</a>
                </li>
                <!-- Fitur Utama -->
                <li class="nav-item">
                    <a class="nav-link" href="#fitur">Fitur Utama</a>
                </li>
                <!-- Testimoni Pengguna -->
                <li class="nav-item">
                    <a class="nav-link" href="#testimoni">Testimoni Pengguna</a>
                </li>
                <!-- Team Members -->
                <li class="nav-item">
                    <a class="nav-link" href="#team">Team Members</a>
                </li>
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="btn btn-secondary" href="#">Sign In</a>
                </li>
            </ul>
        </div>
    </div>
</nav>