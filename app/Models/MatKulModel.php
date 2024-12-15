<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatKulModel extends Model
{
    use HasFactory;

    protected $table = 'mata_kuliah'; // Nama tabel
    protected $primaryKey = 'id_matkul'; // Primary key
    protected $fillable = ['id_user', 'kode_matkul', 'nama_matkul']; // Kolom yang bisa diisi

    public function user():BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'id_user','id_user');
    }
}
