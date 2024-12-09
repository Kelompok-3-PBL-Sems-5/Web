<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
   use HasFactory;

    protected $table = 'm_user'; // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'user_id'; // Mendefinisikan primary key dari tabel yang digunakan
    protected $fillable = ['id_user', 'id_level', 'nama_user', 'username_user', 'password_user', 'nidn_user', 'gelar_akademik', 'email_user', 'created_at', 'updated_at'];

    protected $hiidden = ['password']; // jangan di tampilkan saat select

    protected $casts = ['password' => 'hashed']; // casting password agar otomatis di hash
}