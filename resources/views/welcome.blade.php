@extends('layouts.template')

@section('content')
<!-- Intro Section -->
<div class="row">
    <div class="col-12">
        <div class="alert alert-info">
            <h4 class="alert-heading">Selamat Datang di Dashboard Sertifikasi & Pelatihan</h4>
            <p>Dashboard ini menyajikan informasi terkini terkait pelatihan dan sertifikasi dosen di Jurusan Teknologi Informasi, Politeknik Negeri Malang.</p>
        </div>
    </div>
</div>

<!-- Info Boxes -->
<div class="row">
    <div class="col-12 col-sm-6 col-md-6">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Jumlah Dosen Terdaftar</span>
                <span class="info-box-number" id="jumlahDosen" data-toggle="modal" data-target="#dosenModal" style="cursor: pointer;">10 Dosen</span>
                {{-- <small class="text-muted">Dosen yang terdaftar aktif.</small> --}}
                <small class="text-muted">Klik untuk detail</small>
            </div>
        </div>
    </div>
</div>

<!-- Diagram Pelatihan Pertahun -->
<div class="row">
    <div class="col-12 col-sm-6 col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Diagram Pelatihan Pertahun</h3>
            </div>
            <div class="card-body">
                <canvas id="chartPelatihan"></canvas>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Diagram Sertifikasi Pertahun</h3>
            </div>
            <div class="card-body">
                <canvas id="chartSertifikasi"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="row mb-8">
    <div class="col-12 col-md-6 filter-section">
        <div class="form-group">
            <label for="filterPelatihan">Filter Pelatihan:</label>
            <select id="filterPelatihan" class="form-control">
                <option value="all">Semua Pelatihan</option>
                <option value="nasional">Pelatihan Nasional</option>
                <option value="internasional">Pelatihan Internasional</option>
            </select>
        </div>
    </div>
    <div class="col-12 col-md-6 filter-section">
        <div class="form-group">
            <label for="filterSertifikasi">Filter Sertifikasi:</label>
            <select id="filterSertifikasi" class="form-control">
                <option value="all">Semua Sertifikasi</option>
                <option value="profesi">Sertifikasi Profesi</option>
                <option value="keahlian">Sertifikasi Keahlian</option>
            </select>
        </div>
    </div>
</div>

<!-- Modal untuk Tabel Dosen -->
<div class="modal fade" id="dosenModal" tabindex="-1" aria-labelledby="dosenModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg d-flex justify-content-center align-items-center">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dosenModalLabel">Daftar Dosen Terdaftar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" id="tabelDosen">
                    <thead>
                        <tr>
                            <th style="width: 20%;">No</th> <!-- Lebar kolom Nomor -->
                            <th style="width: 40%;">Nama Dosen</th> <!-- Lebar kolom Nama Dosen -->
                            <th style="width: 20%;">Email</th> <!-- Lebar kolom Email -->
                            <th style="width: 20%;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Dr. Andi Setiawan</td>
                            <td>andi.setiawan@polinema.ac.id</td>
                            <td>Aktif</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Prof. Siti Aisyah</td>
                            <td>siti.aisyah@polinema.ac.id</td>
                            <td>Aktif</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Dr. Budi Santoso</td>
                            <td>budi.santoso@polinema.ac.id</td>
                            <td>Aktif</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Dr. Rina Puspita</td>
                            <td>rina.puspita@polinema.ac.id</td>
                            <td>Aktif</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Prof. Zainal Arifin</td>
                            <td>zainal.arifin@polinema.ac.id</td>
                            <td>Aktif</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Dr. Aulia Wati</td>
                            <td>aulia.wati@polinema.ac.id</td>
                            <td>Aktif</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Prof. Muhammad Rizki</td>
                            <td>rizki.muhammad@polinema.ac.id</td>
                            <td>Aktif</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Dr. Maya Lestari</td>
                            <td>maya.lestari@polinema.ac.id</td>
                            <td>Aktif</td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>Prof. Taufik Hidayat</td>
                            <td>taufik.hidayat@polinema.ac.id</td>
                            <td>Aktif</td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>Dr. Asep Kusnadi</td>
                            <td>asep.kusnadi@polinema.ac.id</td>
                            <td>Aktif</td>
                        </tr>
                        <tr>
                            <td>11</td>
                            <td>Prof. Irma Liana</td>
                            <td>irma.liana@polinema.ac.id</td>
                            <td>Aktif</td>
                        </tr>
                        <tr>
                            <td>12</td>
                            <td>Dr. Aldo Sutrisno</td>
                            <td>aldo.sutrisno@polinema.ac.id</td>
                            <td>Aktif</td>
                        </tr>
                        <tr>
                            <td>13</td>
                            <td>Prof. Nita Purnama</td>
                            <td>nita.purnama@polinema.ac.id</td>
                            <td>Aktif</td>
                        </tr>
                        <tr>
                            <td>14</td>
                            <td>Dr. Dian Pratama</td>
                            <td>dian.pratama@polinema.ac.id</td>
                            <td>Aktif</td>
                        </tr>
                        <tr>
                            <td>15</td>
                            <td>Prof. Rizky Ramadhan</td>
                            <td>rizky.ramadhan@polinema.ac.id</td>
                            <td>Aktif</td>
                        </tr>
                        <tr>
                            <td>16</td>
                            <td>Dr. Vina Sari</td>
                            <td>vina.sari@polinema.ac.id</td>
                            <td>Aktif</td>
                        </tr>
                        <tr>
                            <td>17</td>
                            <td>Prof. Darmawan Suprapto</td>
                            <td>darmawan.suprapto@polinema.ac.id</td>
                            <td>Aktif</td>
                        </tr>
                        <tr>
                            <td>18</td>
                            <td>Dr. Lina Wulandari</td>
                            <td>lina.wulandari@polinema.ac.id</td>
                            <td>Aktif</td>
                        </tr>
                        <tr>
                            <td>19</td>
                            <td>Prof. Dedi Santoso</td>
                            <td>dedi.santoso@polinema.ac.id</td>
                            <td>Aktif</td>
                        </tr>
                        <tr>
                            <td>20</td>
                            <td>Dr. Sri Rahayu</td>
                            <td>sri.rahayu@polinema.ac.id</td>
                            <td>Aktif</td>
                        </tr>
                        <!-- Tambahkan lebih banyak data jika perlu -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('css')
<style>
    .card-header {
        background-color: #007bff;
        color: white;
    }

    .card-body {
        position: relative;
    }

    .form-group {
        margin-top: 20px;
    }

    .alert-info {
        border-left: 4px solid #007bff;
        padding: 15px;
    }

    .info-box-content {
        cursor: pointer;
    }

    .modal-header {
        background-color: #007bff;
        color: white;
    }

    #tabelDosen th:nth-child(1), #tabelDosen td:nth-child(1) {
    width: 10%; /* Kolom Nomor */
    }

    #tabelDosen th:nth-child(2), #tabelDosen td:nth-child(2) {
        width: 40%; /* Kolom Nama Dosen */
    }

    #tabelDosen th:nth-child(3), #tabelDosen td:nth-child(3) {
        width: 35%; /* Kolom Email */
    }

    .filter-section {
        margin-bottom: 25px;
    }
</style>

<!-- Tambahkan CSS DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Tambahkan script DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        // Inisialisasi DataTable pada tabel dosen
        $('table').DataTable();

        // Data untuk Diagram Pelatihan
        const pelatihanData = {
            years: ['2022', '2023', '2024', '2025', '2026'],
            nasional: [10, 12, 14, 15, 16],
            internasional: [5, 6, 7, 8, 9]
        };

        // Data untuk Diagram Sertifikasi
        const sertifikasiData = {
            years: ['2022', '2023', '2024', '2025', '2026'],
            profesi: [8, 9, 10, 11, 12],
            keahlian: [4, 5, 6, 7, 8]
        };

        // Diagram Pelatihan Pertahun
        const ctxPelatihan = document.getElementById('chartPelatihan').getContext('2d');
        let chartPelatihan = new Chart(ctxPelatihan, {
            type: 'bar',
            data: {
                labels: pelatihanData.years,
                datasets: [
                    {
                        label: 'Nasional',
                        data: pelatihanData.nasional,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    },
                    {
                        label: 'Internasional',
                        data: pelatihanData.internasional,
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Jumlah Pelatihan Pertahun' },
                },
            },
        });

        // Diagram Sertifikasi Pertahun
        const ctxSertifikasi = document.getElementById('chartSertifikasi').getContext('2d');
        let chartSertifikasi = new Chart(ctxSertifikasi, {
            type: 'bar',
            data: {
                labels: sertifikasiData.years,
                datasets: [
                    {
                        label: 'Profesi',
                        data: sertifikasiData.profesi,
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    },
                    {
                        label: 'Keahlian',
                        data: sertifikasiData.keahlian,
                        backgroundColor: 'rgba(153, 102, 255, 0.7)',
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Jumlah Sertifikasi Pertahun' },
                },
            },
        });

        // Update chart Pelatihan berdasarkan filter
        $('#filterPelatihan').change(function() {
            const selectedValue = $(this).val();
            let updatedData = {
                labels: pelatihanData.years,
                datasets: []
            };

            if (selectedValue === 'nasional' || selectedValue === 'all') {
                updatedData.datasets.push({
                    label: 'Nasional',
                    data: pelatihanData.nasional,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                });
            }

            if (selectedValue === 'internasional' || selectedValue === 'all') {
                updatedData.datasets.push({
                    label: 'Internasional',
                    data: pelatihanData.internasional,
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                });
            }

            chartPelatihan.data = updatedData;
            chartPelatihan.update();
        });

        // Update chart Sertifikasi berdasarkan filter
        $('#filterSertifikasi').change(function() {
            const selectedValue = $(this).val();
            let updatedData = {
                labels: sertifikasiData.years,
                datasets: []
            };

            if (selectedValue === 'profesi' || selectedValue === 'all') {
                updatedData.datasets.push({
                    label: 'Profesi',
                    data: sertifikasiData.profesi,
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                });
            }

            if (selectedValue === 'keahlian' || selectedValue === 'all') {
                updatedData.datasets.push({
                    label: 'Keahlian',
                    data: sertifikasiData.keahlian,
                    backgroundColor: 'rgba(153, 102, 255, 0.7)',
                });
            }

            chartSertifikasi.data = updatedData;
            chartSertifikasi.update();
        });
    });
</script>
@endpush