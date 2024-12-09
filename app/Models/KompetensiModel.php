<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KompetensiModel extends Model
{
    use HasFactory;
    protected $table = 'kompetensi'; // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'id_kompetensi'; // Mendefinisikan primary key dari tabel yang digunakan

    // Kolom yang dapat diisi
    protected $fillable = ['nama_kompetensi','id_user', 'id_prodi'];

    public function user(): BelongsTo{
        return $this->belongsTo(UserModel::class, 'id_user', 'id_user');
    }

    public function prodi(): BelongsTo{
        return $this->belongsTo(ProdiModel::class, 'id_prodi', 'id_prodi');
    }

}
