<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasNilai extends Model
{
    use HasFactory;

    protected $table = 'tugas_nilai';

    protected $fillable = [
        'jawaban_id',
        'nilai',
        'dosen_id'
    ];

    // Relasi ke Jawaban Tugas
    public function jawaban()
    {
        return $this->belongsTo(TugasJawaban::class, 'jawaban_id');
    }

    // Relasi ke Dosen (atau Admin yang memberi nilai)
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }
}
