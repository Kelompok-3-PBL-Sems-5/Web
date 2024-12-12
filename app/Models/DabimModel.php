<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DabimModel extends Model
{
    use HasFactory;

    protected $table = 'data_bidang_minat';
    protected $primaryKey = 'id_dabim';

    protected $fillable = ['nama_dabim'];

    public function bidang_minat():HasMany
    {
        return $this->hasMany(BidangMinatModel::class, 'id_bidang_minat', 'id_bidang_minat');
    }
    public function pelatihan():HasMany
    {
        return $this->hasMany(PelatihanModel::class, 'id_pelatihan', 'id_pelatihan');
    }
    public function sertifikasi():HasMany
    {
        return $this->hasMany(SertifikasiModel::class, 'id_sertifikasi', 'id_sertifikasi');
    }
    public function rekomendasi():HasMany
    {
        return $this->hasMany(SertifikasiModel::class, 'id_program', 'id_program');
    }
}