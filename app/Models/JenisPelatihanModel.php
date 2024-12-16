<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisPelatihanModel extends Model
{
    use HasFactory;

    protected $table = 't_jenis_pelatihan';
    protected $primaryKey = 'id_jenpel';

    protected $fillable = ['nama_jenpel'];

    public function pelatihan():HasMany
    {
        return $this->hasMany(PelatihanModel::class, 'id_pelatihan', 'id_pelatihan');
    }
    
}