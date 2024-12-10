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
    <li class="nav-header">Data Pengguna</li>
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
    <li class="nav-header">Data Dosen</li>
    <li class="nav-item has-treeview {{ in_array($activeMenu, ['data_dosen', 'bidang_minat', 'mata_kuliah', 'data_historis']) ? 'menu-open' : '' }}">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-chalkboard-teacher"></i>
        <p>
          Data Dosen
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ url('/data_dosen') }}" class="nav-link {{ ($activeMenu == 'data_dosen') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Data Dosen</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/bidang_minat') }}" class="nav-link {{ ($activeMenu == 'bidang_minat') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Bidang Minat</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/mata_kuliah') }}" class="nav-link {{ ($activeMenu == 'mata_kuliah') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Mata Kuliah</p>
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
              <a href="{{ url('/data_sertifikasi') }}" class="nav-link {{ ($activeMenu == 'data_sertifikasi') ? 'active' : '' }}">
                <i class="far fa-dot-circle nav-icon"></i>
                <p>Data Sertifikasi</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/data_pelatihan') }}" class="nav-link {{ ($activeMenu == 'data_pelatihan') ? 'active' : '' }}">
                <i class="far fa-dot-circle nav-icon"></i>
                <p>Data Pelatihan</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </li>

    <!-- Data Vendor -->
    <li class="nav-header">Data Vendor</li>
    <li class="nav-item">
      <a href="{{ url('/data_vendor') }}" class="nav-link {{ ($activeMenu == 'data_vendor') ? 'active' : '' }}">
        <i class="nav-icon far fa-handshake"></i>
        <p>Data Vendor</p>
      </a>
    </li>

    <!-- Data Manage -->
    <li class="nav-header">Data Manage</li>
    <li class="nav-item">
      <a href="{{ url('/daftar_sertifikasi_pelatihan') }}" class="nav-link {{ ($activeMenu == 'daftar_sertifikasi_pelatihan') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tasks"></i>
        <p>Sertifikasi-Pelatihan</p>
      </a>
    </li>

    <!-- Data Kompetensi Prodi -->
    <li class="nav-header">Data Kompetensi Prodi</li>
    <li class="nav-item has-treeview {{ in_array($activeMenu, ['data_prodi', 'data_kompetensi', 'data_kompetensi_prodi']) ? 'menu-open' : '' }}">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-graduation-cap"></i>
        <p>
          Data Kompetensi Prodi
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ url('/data_prodi') }}" class="nav-link {{ ($activeMenu == 'data_prodi') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Data Prodi</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/data_kompetensi') }}" class="nav-link {{ ($activeMenu == 'data_kompetensi') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Data Kompetensi</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/data_kompetensi_prodi') }}" class="nav-link {{ ($activeMenu == 'data_kompetensi_prodi') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Data Kompetensi Prodi</p>
          </a>
        </li>
      </ul>
    </li>

    <!-- Surat Tugas -->
    <li class="nav-header">Surat Tugas</li>
    <li class="nav-item">
      <a href="{{ url('/surat_tugas') }}" class="nav-link {{ ($activeMenu == 'surat_tugas') ? 'active' : '' }}">
        <i class="nav-icon far fa-envelope"></i>
        <p>Surat Tugas</p>
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
