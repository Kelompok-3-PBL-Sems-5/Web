<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodeModel extends Model
{
    protected $table = 't_periode';
    protected $primaryKey = 'id_periode';
    public $timestamps = true;

    protected $fillable = [
        'id_sertifikasi',
        'id_user',
        'status',
        'created_at',
        'updated_at'
    ];

    public function sertifikasi()
    {
        return $this->belongsTo(SertifikasiModel::class, 'id_sertifikasi', 'id_sertifikasi');
    }
    public function pelatihan()
    {
        return $this->hasMany(PelatihanModel::class, 'id_user', 'id_pelatihan');
    }
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'id_user', 'id_user')->from('m_user');
    }
}