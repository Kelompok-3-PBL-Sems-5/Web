<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class SertifikasiModel extends Model
{
    use HasFactory;
    protected $table = 't_data_sertifikasi'; // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'id_sertifikasi'; // Mendefinisikan primary key dari tabel yang digunakan
    protected $fillable = ['id_user','id_vendor', 'id_dabim', 'id_damat', 'nama_sertif', 'jenis_sertif', 'tgl_mulai_sertif', 'tgl_akhir_sertif', 'jenis_pendanaan_sertif', 'bukti_sertif', 'status'];
    public function user():BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'id_user','id_user');
    }
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
        return $this->belongsTo(BidangMinatModel::class, 'id_dabim','id_dabim');
    }
    public function getStatusAttribute()
    {
        $now = Carbon::now();

        if ($now->lt(Carbon::parse($this->tgl_mulai_sertif))) {
            return 'Belum Dimulai';
        } elseif ($now->between(Carbon::parse($this->tgl_mulai_sertif), Carbon::parse($this->tgl_akhir_sertif))) {
            return 'Aktif';
        } else {
            return 'Selesai';
        }
    }
}