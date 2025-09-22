<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';
    protected $fillable = [
        'kelas_id',
        'judul',
        'deskripsi',
        'deadline',
        'pengingat_interval'
    ];
    protected $casts = [
        'deadline' => 'datetime',
    ];

    protected $dates = ['deadline'];

    // Relasi ke Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    // Relasi ke TugasFile
    public function files()
    {
        return $this->hasMany(TugasFile::class);
    }

    // Relasi ke TugasMahasiswa (tugas yang dikumpulkan mahasiswa)
    public function tugasJawaban()
    {
        return $this->hasMany(TugasJawaban::class, 'tugas_id');
    }
}
