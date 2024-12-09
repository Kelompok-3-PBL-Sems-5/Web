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
        'telp_vendor',
        'jenis_vendor'
    ];

    public function barang():HasMany
    {
        return $this->hasMany(SertifikasiModel::class, 'id_sertifikasi', 'id_sertifikasi');
    }

}
