<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KopentensiProdi extends Model
{
    use HasFactory;
    protected $table = 'kompetensi_prodi'; // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'id_kompetensi_prodi'; // Mendefinisikan primary key dari tabel yang digunakan

    // Kolom yang dapat diisi
    protected $fillable = ['id_kompetensi_prodi', 'id_kompetensi', 'id_user', 'tahun_berlaku'];
}
