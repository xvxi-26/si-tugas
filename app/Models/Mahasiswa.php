<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

class Mahasiswa extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $table = 'mahasiswa';

    protected $fillable = [
        'nama',
        'nim',
        'nomor_telepon',
        'chat_id',
        'angkatan',
        'email',
        'password',
        'activate_token',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function kelas(){
        return $this->belongsToMany(Kelas::class, 'kelas_mahasiswa');
    }
    public function tugasJawaban()
    {
        return $this->hasMany(TugasJawaban::class, 'mahasiswa_id');
    }

}
