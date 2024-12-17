@extends('layouts.template')

@section('content')
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
    data-keyboard="false" data-width="75%" aria-hidden="true"></div>

<div class="container rounded bg-white profile-container"> <!-- Ganti class border dengan profile-container -->

    <!-- Data Historis (Sertifikasi dan Pelatihan) -->
    <div class="row mt-4">
        <div class="col-md-12">
            <h4 class="profile-header">Data Historis Sertifikasi dan Pelatihan</h4>
            <table class="table table-bordered table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>Tipe</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Akhir</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Gabungkan data pelatihan dan sertifikasi
                        $dataHistoris = $pelatihan->merge($sertifikasi)->sortByDesc(function ($item) {
                            return $item->tgl_mulai ?? $item->tgl_mulai_sertif; // Menyortir berdasarkan tanggal
                        });
                    @endphp

                    @foreach ($dataHistoris as $data)
                        <tr>
                            <td>
                                @if ($data instanceof App\Models\PelatihanModel)
                                    Pelatihan
                                @elseif ($data instanceof App\Models\SertifikasiModel)
                                    Sertifikasi
                                @endif
                            </td>
                            <td>
                                @if ($data instanceof App\Models\PelatihanModel)
                                    {{ $data->nama_pelatihan }}
                                @elseif ($data instanceof App\Models\SertifikasiModel)
                                    {{ $data->nama_sertif }}
                                @endif
                            </td>
                            <td>
                                @if ($data instanceof App\Models\PelatihanModel)
                                    {{ $data->level_pelatihan }}
                                @elseif ($data instanceof App\Models\SertifikasiModel)
                                    {{ $data->jenis_sertif }}
                                @endif
                            </td>
                            <td>
                                @if ($data instanceof App\Models\PelatihanModel)
                                    {{ $data->tgl_mulai }}
                                @elseif ($data instanceof App\Models\SertifikasiModel)
                                    {{ $data->tgl_mulai_sertif }}
                                @endif
                            </td>
                            <td>
                                @if ($data instanceof App\Models\PelatihanModel)
                                    {{ $data->tgl_akhir }}
                                @elseif ($data instanceof App\Models\SertifikasiModel)
                                    {{ $data->tgl_akhir_sertif }}
                                @endif
                            </td>
                            <td>{{ $data->status }}</td>
                            <td>
                                <button onclick="modalAction('{{ url('/' . ($data instanceof App\Models\PelatihanModel ? 'pelatihan' : 'sertifikasi') . '/' . $data->id) }}')" class="btn btn-sm btn-warning">Edit</button>
                                <button onclick="deleteData('{{ url('/' . ($data instanceof App\Models\PelatihanModel ? 'pelatihan' : 'sertifikasi') . '/' . $data->id) }}')" class="btn btn-sm btn-danger">Hapus</button>
                            </td>
                        </tr>
                    @endforeach

                    @if ($dataHistoris->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data historis tersedia</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection

@push('css')
<style>
    /* Tambahkan CSS untuk styling */
</style>
@endpush

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    function deleteData(url) {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert(response.message);
                    location.reload();
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan. Mohon coba lagi.');
                }
            });
        }
    }
</script>
@endpush
