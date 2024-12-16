<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekDosenModel extends Model
{
    protected $table = 'rekomendasi_dosen'; // Sesuaikan dengan nama tabel yang ada di database

    protected $primaryKey = 'id_rekdosen'; // Menyebutkan kolom primary key

    protected $fillable = [
        'id_program',
        'id_user',
        'status'
    ];

    public function rekomendasi():BelongsTo
    {
        return $this->belongsTo(RekomendasiModel::class, 'id_program','id_program');
    }
    public function user():BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'id_user','id_user');
    }
}