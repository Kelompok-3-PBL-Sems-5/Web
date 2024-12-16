<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengajuanPelatihanModel extends Model
{
    use HasFactory;

    // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $table = 'pengajuan_pelatihan';

    // Mendefinisikan primary key dari tabel supplier
    protected $primaryKey = 'id_pengpelatihan'; 

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'id_user', 
        'judul', 
        'id_vendor',
        'tujuan',
        'relevansi',
        'tanggal',
        'lokasi',
        'biaya',
        'dana',
        'implementasi',
        'link',
        'status',
        'komentar'
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(UserModel::class, 'id_user', 'id_user');
    }
    public function vendor(): BelongsTo{
        return $this->belongsTo(VendorModel::class, 'id_vendor', 'id_vendor');
    }

}
