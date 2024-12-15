<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class RekomendasiModel extends Model
{
    protected $table = 't_data_rekomendasi_program'; // Sesuaikan dengan nama tabel yang ada di database

    protected $primaryKey = 'id_program'; // Menyebutkan kolom primary key

    protected $fillable = [
        'id_vendor',
        'jenis_program',
        'nama_program',
        'id_damat',
        'id_dabim',
        'tanggal_program',
        'level_program',
        'kuota_program',
    ];
    
    public function vendor():BelongsTo
    {
        return $this->belongsTo(VendorModel::class, 'id_vendor','id_vendor');
    }
    public function damat():BelongsTo
    {
        return $this->belongsTo(DamatModel::class, 'id_damat','id_damat');
    }
    public function dabim():BelongsTo
    {
        return $this->belongsTo(DabimModel::class, 'id_dabim','id_dabim');
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
    public function rekdosen():HasMany
    {
        return $this->hasMany(RekDosenModel::class, 'id_rekdosen', 'id_rekdosen');
    }
}
