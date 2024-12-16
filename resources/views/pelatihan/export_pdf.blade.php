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
    <h3 class="text-center">LAPORAN DATA PELATIHAN</h4>
        <table class="border-all">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Nama User</th>
                    <th>Nama Vendor</th>
                    <th>Nama Pelatihan</th>
                    <th>Jenis Pelatihan</th>
                    <th class="text-right">Tanggal Mulai</th>
                    <th class="text-right">Tanggal Akhir</th>
                    <th>Level Pelatihan</th>
                    <th>Jenis Pendanaan</th>
                    <th>Status</th>
                </tr>                
            </thead>
            <tbody>
                @foreach ($pelatihan as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->user->nama_user }}</td>
                        <td>{{ $item->vendor->nama_vendor }}</td>
                        <td>{{ $item->nama_pelatihan }}</td>
                        <td>{{ $item->jenis_pelatihan }}</td>
                        <td class="text-right">{{ $item->tgl_mulai }}</td>
                        <td class="text-right">{{ $item->tgl_akhir }}</td>
                        <td>{{ $item->level_pelatihan }}</td>
                        <td>{{ $item->jenis_pendanaan }}</td>
                        <td>{{ $item->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>        
</body>
</html>