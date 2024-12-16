<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 6px 20px 5px 20px;
            line-height: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td,
        th {
            padding: 4px 3px;
        }
        th {
            text-align: left;
        }
        .d-block {
            display: block;
        }
        img.image {
            width: auto;
            height: 80px;
            max-width: 150px;
            max-height: 150px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .p-1 {
            padding: 5px 1px 5px 1px;
        }
        .font-10 {
            font-size: 10pt;
        }
        .font-11 {
            font-size: 11pt;
        }
        .font-12 {
            font-size: 12pt;
        }
        .font-13 {
            font-size: 13pt;
        }
        .border-bottom-header {
            border-bottom: 1px solid;
        }
        .border-all,
        .border-all th,
        .border-all td {
            border: 1px solid;
        }
    </style>
</head>
<body>
    <table class="border-bottom-header">
        <tr>
            <td width="15%" class="text-center">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSgOk1o9DKh__qOFazj2DSIJx7nP6Ei4C_eHA&s" alt="Logo" style="max-width: 100%; height: auto;">
                </td>
            <td width="85%">
                <span class="text-center d-block font-11 font-bold mb-1">KEMENTERIAN
                    PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</span>
                <span class="text-center d-block font-13 font-bold mb-1">POLITEKNIK NEGERI
                    MALANG</span>
                <span class="text-center d-block font-10">Jl. Soekarno-Hatta No. 9 Malang
                    65141</span>
                <span class="text-center d-block font-10">Telepon (0341) 404424 Pes. 101-
                    105, 0341-404420, Fax. (0341) 404420</span>
                <span class="text-center d-block font-10">Laman: www.polinema.ac.id</span>
            </td>
        </tr>
    </table>
    <h3 class="text-center">LAPORAN DATA PENGAJUAN SERTIFIKASI</h4>
        <table class="border-all">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Nama User</th>
                    <th class="text-center">Nama Vendor</th>
                    <th class="text-center">Judul Sertifikasi</th>
                    <th class="text-center">Tujuan</th>
                    <th class="text-center">Relevansi dengan Tugas Akademik</th>
                    <th class="text-center">Tanggal Pelaksanaan</th>
                    <th class="text-center">Lokasi (Online/Offline)</th>
                    <th class="text-center">Biaya</th>
                    <th class="text-center">Sumber Dana</th>
                    <th class="text-center">Rencana Implementasi</th>
                    <th class="text-center">Link Informasi Resmi</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Komentar Pimjur</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengajuan_sertifikasi as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->user->nama_user }}</td>
                        <td>{{ $item->vendor->nama_vendor }}</td>
                        <td class="text-right">{{ $pengajuan_sertifikasi->judul }}</td>
                        <td class="text-right">{{ $pengajuan_sertifikasi->tujuan }}</td>
                        <td class="text-right">{{ $pengajuan_sertifikasi->relevansi }}</td>
                        <td class="text-right">{{ $pengajuan_sertifikasi->tanggal }}</td>
                        <td class="text-right">{{ $pengajuan_sertifikasi->lokasi }}</td>
                        <td class="text-right">{{ $pengajuan_sertifikasi->biaya }}</td>
                        <td class="text-right">{{ $pengajuan_sertifikasi->dana }}</td>
                        <td class="text-right">{{ $pengajuan_sertifikasi->implementasi }}</td>
                        <td class="text-right"><a href="{{ $pengajuan_sertifikasi->link }}" target="_blank">{{ $pengajuan_sertifikasi->link }}</a></td>
                        <td class="text-right">{{ $pengajuan_sertifikasi->status }}</td>
                        <td class="text-right">{{ $pengajuan_sertifikasi->komentar }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>        
</body>
</html>