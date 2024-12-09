<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProdiModel extends Model
{
    use HasFactory;

    protected $table = 'data_prodi'; // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'id_prodi'; // Mendefinisikan primary key dari tabel yang digunakan

    // Kolom yang dapat diisi
    protected $fillable = ['id_prodi', 'nama_prodi', 'kode_prodi', 'id_user', 'nidn_user', 'jenjang'];
    


    // Relasi ke tabel dosen (asumsikan ada tabel dosen yang menyimpan detail dosen)
    /*public function dosen(): BelongsTo
    {
        return $this->belongsTo(DosenModel::class, 'id_dosen', 'id_dosen');
    }

    // Relasi ke tabel jurusan (jika ada tabel jurusan terpisah, tambahkan relasi)
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(JurusanModel::class, 'jurusan', 'jurusan');
    }

    // Fungsi untuk mengakses properti 'jenjang'
    protected function jenjang(): Attribute
    {
        return Attribute::make(
            get: fn ($jenjang) => strtoupper($jenjang), // Contoh: mengubah jenjang jadi uppercase
        );
    }

    // Fungsi untuk mengakses NIDN Dosen
    protected function nidnDosen(): Attribute
    {
        return Attribute::make(
            get: fn ($nidn_user) => 'NIDN: ' . $nidn_user, // Contoh: menambahkan prefix pada NIDN dosen
        );
    }*/
}
