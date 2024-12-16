<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VendorModel extends Model
{
    use HasFactory;

    // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $table = 't_vendor';

    // Mendefinisikan primary key dari tabel supplier
    protected $primaryKey = 'id_vendor'; 

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'nama_vendor', 
        'alamat_vendor', 
        'jenis_vendor',
        'telp_vendor',
        'alamat_web'
    ];

    public function sertifikasi():HasMany
    {
        return $this->hasMany(SertifikasiModel::class, 'id_sertifikasi', 'id_sertifikasi');
    }

    public function pengajuan_sertifikasi():HasMany
    {
        return $this->hasMany(PengajuanSertifikasiModel::class, 'id_pengsertifikasi', 'id_pengsertifikasi');
    }

    public function pengajuan_pelatihan():HasMany
    {
        return $this->hasMany(PengajuanPelatihanModel::class, 'id_pengpelatihan', 'id_pengpelatihan');
    }

}
