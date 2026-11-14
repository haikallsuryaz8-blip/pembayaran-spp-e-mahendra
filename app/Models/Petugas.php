<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Petugas extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'petugas';
    protected $primaryKey = 'id_petugas';
    protected $fillable = ['username', 'password', 'nama_petugas', 'level'];
    protected $hidden = ['password', 'remember_token'];

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_petugas', 'id_petugas');
    }
}
