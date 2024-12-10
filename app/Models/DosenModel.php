<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DosenModel extends Model
{
    use HasFactory;

    // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $table = 't_dosen';

    // Mendefinisikan primary key dari tabel supplier
    protected $primaryKey = 'id_dosen'; 

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'nama_dosen', 
        'username_dosen', 
        'password_dosen', 
        'nidn_dosen',
        'gelar_akademik',
        'email_dosen'
    ];
}
