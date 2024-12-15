<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable implements JWTSubject
{

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }



    use HasFactory;

    // Specify the table name, in case it doesn't follow Laravel's default naming convention
    protected $table = 'm_user';

    // Define the primary key if it's not "id"
    protected $primaryKey = 'id_user';

    // Specify which attributes can be mass assigned
    protected $fillable = [
        'id_level',
        'nama_user',
        'username_user',
        'password_user',
        'nidn_user',
        'gelar_akademik',
        'email_user',
        'foto'
    ];

    // Hide sensitive attributes like passwords from being visible in JSON or array outputs
    protected $hidden = [
        'password_user',
    ];

    // If you’re using a different key type, uncomment this line and specify it, e.g., 'string' for non-integer keys
    // protected $keyType = 'int';
    public function level()
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }
}
