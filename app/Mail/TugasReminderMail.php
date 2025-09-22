<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Tugas;
use App\Models\Mahasiswa;

class TugasReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tugas;
    public $mahasiswa;

    /**
     * Create a new message instance.
     */
    public function __construct(Tugas $tugas, Mahasiswa $mahasiswa)
    {
        $this->tugas = $tugas;
        $this->mahasiswa = $mahasiswa;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Pengingat Tugas: ' . $this->tugas->judul)
                    ->view('emails.tugas_reminder')
                    ->with([
                        'namaMahasiswa' => $this->mahasiswa->nama,
                        'judulTugas' => $this->tugas->judul,
                        'deadline' => $this->tugas->deadline->format('d M Y, H:i'),
                        'deskripsi' => $this->tugas->deskripsi,
                    ]);
    }
}
