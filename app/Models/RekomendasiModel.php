<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class RekomendasiModel extends Model
{
    protected $table = 't_data_rekomendasi_program'; // Sesuaikan dengan nama tabel yang ada di database

    protected $primaryKey = 'id_program'; // Menyebutkan kolom primary key

    protected $fillable = [
        'id_vendor',
        'jenis_program',
        'nama_program',
        'id_matkul',
        'id_bidang_minat',
        'tanggal_program',
        'level_program',
        'kuota_program',
    ];
    
    public function vendor():BelongsTo
    {
        return $this->belongsTo(VendorModel::class, 'id_vendor','id_vendor');
    }
    public function matkul():BelongsTo
    {
        return $this->belongsTo(MatKulModel::class, 'id_matkul','id_matkul');
    }
    public function bidang_minat():BelongsTo
    {
        return $this->belongsTo(BidangMinatModel::class, 'id_bidang_minat','id_bidang_minat');
    }
    public function getStatusAttribute()
    {
        $now = Carbon::now();

        if ($now->lt(Carbon::parse($this->tanggal_program))) {
            return 'Belum Dimulai';
        } else {
            return 'Selesai';
        }
    }
}
