<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KompetensiModel extends Model
{
    use HasFactory;
    protected $table = 'kompetensi'; // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'id_kompetensi'; // Mendefinisikan primary key dari tabel yang digunakan

    // Kolom yang dapat diisi
    protected $fillable = ['nama_kompetensi','id_user'];

}
