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

    public function user(): BelongsTo{
        return $this->belongsTo(UserModel::class, 'id_user', 'id_user');
    }

    public function kompetensi():HasMany
    {
        return $this->hasMany(KompetensiModel::class, 'id_kompetensi', 'id_kompetensi');
    }
    
}