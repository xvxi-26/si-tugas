<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasJawaban extends Model
{
    use HasFactory;

    protected $table = 'tugas_jawaban';

    protected $fillable = [
        'tugas_id',
        'mahasiswa_id',
        'file_path',
        'status',
        'submitted_at'
    ];

    protected $dates = ['submitted_at'];

    // Relasi ke Tugas
    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

    // Relasi ke Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    // Relasi ke Tugas Nilai
    public function nilai()
    {
        return $this->hasOne(TugasNilai::class, 'jawaban_id');
    }
}
