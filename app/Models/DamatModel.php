<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DamatModel extends Model
{
    use HasFactory;

    protected $table = 'data_mata_kuliah';
    protected $primaryKey = 'id_damat';

    protected $fillable = ['nama_damat', 'kode_damat'];

    public function matkul():HasMany
    {
        return $this->hasMany(MatKulModel::class, 'id_matkul', 'id_matkul');
    }
    public function pelatihan():HasMany
    {
        return $this->hasMany(PelatihanModel::class, 'id_pelatihan', 'id_pelatihan');
    }
    public function sertifikasi():HasMany
    {
        return $this->hasMany(SertifikasiModel::class, 'id_sertifikasi', 'id_sertifikasi');
    }
    
}