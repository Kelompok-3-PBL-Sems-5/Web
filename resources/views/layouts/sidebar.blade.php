<div class="sidebar">
  <!-- SidebarSearch Form -->
  <div class="form-inline mt-2">
    <div class="input-group" data-widget="sidebar-search">
      <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
      <div class="input-group-append">
        <button class="btn btn-sidebar">
          <i class="fas fa-search fa-fw"></i>
        </button>
      </div>
    </div>
  </div>
  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <a href="{{ url('/dashboard') }}" class="nav-link {{ ($activeMenu == 'dashboard') ? 'active' : '' }} ">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>Dashboard Statistik</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ url('/profile') }}" class="nav-link {{ $activeMenu == 'profile' ? 'active' : '' }} ">
            <i class="nav-icon far fa-address-card"></i>
            <p>Profile</p>
        </a>
    </li>

    <!-- Data Pengguna -->
    <li class="nav-header blue-header">Data Pengguna</li>
    <li class="nav-item has-treeview {{ in_array($activeMenu, ['level', 'user']) ? 'menu-open' : '' }}">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>
          Data Pengguna
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Level User</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/user') }}" class="nav-link {{ ($activeMenu == 'user') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Data User</p>
          </a>
        </li>
      </ul>
    </li>

    <!-- Data Dosen -->
    <li class="nav-header blue-header">Data Dosen</li>
    <li class="nav-item has-treeview {{ in_array($activeMenu, ['dosen', 'bidang_minat', 'matkul', 'data_sertifikasi', 'data_pelatihan']) ? 'menu-open' : '' }}">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-chalkboard-teacher"></i>
        <p>
          Data Dosen
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        {{-- <li class="nav-item">
          <a href="{{ url('/dosen') }}" class="nav-link {{ $activeMenu == 'dosen' ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Data Dosen</p>
          </a>
        </li> --}}
        <li class="nav-item">
          <a href="{{ url('/bidang_minat') }}" class="nav-link {{ $activeMenu == 'bidang_minat' ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Bidang Minat Dosen</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/matkul') }}" class="nav-link {{ $activeMenu == 'matkul' ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Mata Kuliah Dosen</p>
          </a>
        </li>
        <li class="nav-item has-treeview {{ in_array($activeMenu, ['data_sertifikasi', 'data_pelatihan']) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>
              Data Historis
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('/data_sertifikasi') }}" class="nav-link {{ $activeMenu == 'data_sertifikasi' ? 'active' : '' }}">
                <i class="far fa-dot-circle nav-icon"></i>
                <p>Riwayat Sertifikasi</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/data_pelatihan') }}" class="nav-link {{ $activeMenu == 'data_pelatihan' ? 'active' : '' }}">
                <i class="far fa-dot-circle nav-icon"></i>
                <p>Riwayat Pelatihan</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </li>

    {{-- <!-- Data Vendor -->
    <li class="nav-header blue-header">Data Vendor</li>
    <li class="nav-item">
      <a href="{{ url('/vendor') }}" class="nav-link {{ ($activeMenu == 'vendor') ? 'active' : '' }}">
        <i class="nav-icon far fa-handshake"></i>
        <p>Data Vendor</p>
      </a>
    </li> --}}

    <!-- Data Manage -->
    <li class="nav-header blue-header">Data Manage</li>
    <li class="nav-item has-treeview {{ in_array($activeMenu, ['dabim','damat','vendor','jenis_pelatihan','rekomendasi', 'periode']) ? 'menu-open' : '' }}">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-cogs"></i>
        <p>Data Manage<i class="right fas fa-angle-left"></i></p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ url('/dabim') }}" class="nav-link {{ ($activeMenu == 'dabim') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Daftar Bidang Minat</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/damat') }}" class="nav-link {{ ($activeMenu == 'damat') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Daftar Mata Kuliah</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/vendor') }}" class="nav-link {{ ($activeMenu == 'vendor') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Vendor</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/jenis_pelatihan') }}" class="nav-link {{ ($activeMenu == 'jenis_pelatihan') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Jenis Pelatihan</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/rekomendasi') }}" class="nav-link {{ ($activeMenu == 'rekomendasi') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Rekomendasi Dosen</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/periode') }}" class="nav-link {{ ($activeMenu == 'periode') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Periode Sertifikasi Dosen</p>
          </a>
        </li>
      </ul>
    </li>

    <!-- Data Kompetensi Prodi -->
    <li class="nav-header blue-header">Data Kompetensi Prodi</li>
    <li class="nav-item has-treeview {{ in_array($activeMenu, ['data_prodi', 'kompetensi', 'kompetensi_prodi']) ? 'menu-open' : '' }}">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-graduation-cap"></i>
        <p>
          Data Kompetensi Prodi
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ url('/prodi') }}" class="nav-link {{ ($activeMenu == 'prodi') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Data Prodi</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/kompetensi') }}" class="nav-link {{ ($activeMenu == 'kompetensi') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Data Kompetensi</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/kompetensi_prodi') }}" class="nav-link {{ ($activeMenu == 'kompetensi_prodi') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Data Kompetensi Prodi</p>
          </a>
        </li>
      </ul>
    </li>


    <!-- Pengajuan -->
    <li class="nav-header blue-header">Pengajuan</li>
    <li class="nav-item has-treeview {{ in_array($activeMenu, ['pengajuan_sertifikasi', 'pengajuan_pelatihan']) ? 'menu-open' : '' }}">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-file-alt"></i>
        <p>
          Pengajuan
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <!-- Pengajuan Sertifikasi -->
        <li class="nav-item has-treeview {{ in_array($activeMenu, ['ajukan_sertifikasi', 'riwayat-sertifikasi', 'status_sertifikasi']) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>
              Pengajuan Sertifikasi
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('/ajukan_sertifikasi') }}" class="nav-link {{ ($activeMenu == 'ajukan_sertifikasi') ? 'active' : '' }}">
                <i class="far fa-dot-circle nav-icon"></i>
                <p>Ajukan Baru</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/riwayat-sertifikasi') }}" class="nav-link {{ ($activeMenu == 'riwayat-sertifikasi') ? 'active' : '' }}">
                <i class="far fa-dot-circle nav-icon"></i>
                <p>Riwayat Pengajuan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/status_sertifikasi') }}" class="nav-link {{ ($activeMenu == 'status_sertifikasi') ? 'active' : '' }}">
                <i class="far fa-dot-circle nav-icon"></i>
                <p>Status Pengajuan</p>
              </a>
            </li>
          </ul>
        </li>
        <!-- Pengajuan Pelatihan -->
        <li class="nav-item has-treeview {{ in_array($activeMenu, ['ajukan_pelatihan', 'riwayat_pelatihan', 'status_pelatihan']) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>
              Pengajuan Pelatihan
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('/ajukan_pelatihan') }}" class="nav-link {{ ($activeMenu == 'ajukan_pelatihan') ? 'active' : '' }}">
                <i class="far fa-dot-circle nav-icon"></i>
                <p>Ajukan Baru</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/riwayat_pelatihan') }}" class="nav-link {{ ($activeMenu == 'riwayat_pelatihan') ? 'active' : '' }}">
                <i class="far fa-dot-circle nav-icon"></i>
                <p>Riwayat Pengajuan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/status_pelatihan') }}" class="nav-link {{ ($activeMenu == 'status_pelatihan') ? 'active' : '' }}">
                <i class="far fa-dot-circle nav-icon"></i>
                <p>Status Pengajuan</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </li>


    <!-- Surat Tugas -->
    <li class="nav-header blue-header">Surat Tugas</li>
    <li class="nav-item">
      <a href="{{ url('/surat') }}" class="nav-link {{ ($activeMenu == 'surat') ? 'active' : '' }}">
        <i class="nav-icon far fa-envelope"></i>
        <p>Surat Tugas</p>
      </a>
    </li>

    <li class="nav-header blue-header">Notifikasi</li>
    <li class="nav-item">
      <a href="{{ url('/notifikasi') }}" class="nav-link {{ ($activeMenu == 'notifikasi') ? 'active' : '' }}">
        <i class="nav-icon far fa-envelope"></i>
        <p>Notifikasi</p>
      </a>
    </li>
      
    <!-- Menambahkan Menu Logout -->
    <li class="nav-item">
        <a href="{{ url('logout') }}" class="nav-link"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
        </a>
        <form id="logout-form" action="{{ url('logout') }}" method="GET" style="display: none;">
        </form>
    </li>  

    </ul>
  </nav>
</div>

<style>
  .blue-header {
    color: white !important;                    /* Mengubah warna teks menjadi putih */
    -webkit-text-stroke: 0.5px #a7d1ff;           /* Menambahkan garis tepi biru pada teks */
  }

  .nav-link {
    color: #fff;
    transition: all 0.3s ease;
  }

  .nav-link:hover {
    background-color: #17a2b8 !important;
    color: #fff !important;
  }

  .nav-item.menu-open > .nav-link {
    background-color: #007bff !important;
    color: #fff;
  }

  .nav-treeview > .nav-item > .nav-link.active {
    background-color: #007bff !important;
    color: #fff;
  }

  .nav-icon {
    margin-right: 10px;
  }
</style>

