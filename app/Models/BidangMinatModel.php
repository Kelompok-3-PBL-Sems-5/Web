<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class BidangMinatModel extends Model
{
    use HasFactory;
    protected $table = 'bidang_minat'; // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'id_bidang_minat'; // Mendefinisikan primary key dari tabel yang digunakan
    protected $fillable = ['id_user','id_dabim'];
    
    public function user():BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'id_user','id_user');
    }
    public function dabim():BelongsTo
    {
        return $this->belongsTo(DabimModel::class, 'id_dabim','id_dabim');
    }
}