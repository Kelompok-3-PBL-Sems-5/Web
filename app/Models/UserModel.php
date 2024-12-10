<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable
{
    protected $table = 'm_user';
    protected $primaryKey = 'id_user';
    protected $fillable = [
        'username', 
        'nama_user', 
        'password', 
        'id_level', 
        'nidn_user',
        'gelar_akademik',
        'email_user',
        'foto',
        'created_at', 
        'updated_at'
    ];

    public function level(): BelongsTo{
        return $this->belongsTo(LevelModel::class, 'id_level', 'id_level');
    }

    protected $hidden = ['password'];
    protected $casts = ['password' => 'hashed'];

    public function getRoleName(): string{
        return $this->level->nama_level;
    }
    
    public function hasRole($role): bool{
        return $this->level->kode_level == $role;
    }

    public function getRole(){
        return $this->level->kode_level;
    }

    // public function pelatihan():HasMany
    // {
    //     return $this->hasMany(PelatihanModel::class, 'id_pelatihan', 'id_pelatihan');
    // }

    // public function sertifikasi():HasMany
    // {
    //     return $this->hasMany(SertifikasiModel::class, 'id_sertifikasi', 'id_sertifikasi');
    // }
}