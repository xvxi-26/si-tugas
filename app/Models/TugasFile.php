<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasFile extends Model
{
    use HasFactory;

    protected $table = 'tugas_file';
    protected $fillable = ['tugas_id', 'file_path'];

    // Relasi ke Tugas
    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }
}
