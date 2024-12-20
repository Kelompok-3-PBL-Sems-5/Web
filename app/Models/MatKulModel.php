<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MatKulModel extends Model
{
    use HasFactory;

    protected $table = 'mata_kuliah'; // Nama tabel
    protected $primaryKey = 'id_matkul'; // Primary key
    protected $fillable = ['id_user', 'id_damat']; // Kolom yang bisa diisi

    public function user():BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'id_user','id_user');
    }
    public function damat():BelongsTo
    {
        return $this->belongsTo(DamatModel::class, 'id_damat','id_damat');
    }
}
