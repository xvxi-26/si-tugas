<?php
namespace App\Jobs;

use App\Models\Tugas;
use App\Models\Mahasiswa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\TugasReminderMail;
use Carbon\Carbon;
use App\Services\TelegramService;

class SendTugasNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tugas;

    public function __construct(Tugas $tugas)
    {
        $this->tugas = $tugas;
    }

    public function handle(): void
    {
        $telegramService = new TelegramService();

        if (Carbon::now()->greaterThanOrEqualTo($this->tugas->deadline)) {
            return;
        }

        $mahasiswaList = Mahasiswa::whereHas('kelas', function ($query) {
            $query->where('kelas.id', $this->tugas->kelas_id);
        })->whereDoesntHave('tugasJawaban', function ($query) {
            $query->where('tugas_jawaban.tugas_id', $this->tugas->id);
        })->get();

        foreach ($mahasiswaList as $mahasiswa) {
            // Kirim email
            Mail::to($mahasiswa->email)->send(new TugasReminderMail($this->tugas, $mahasiswa));

            // Kirim notifikasi Telegram jika `chat_id` tersedia
            if ($mahasiswa->chat_id) {
                $message = "Reminder Tugas: {$this->tugas->judul}\n" .
                           "Deadline: {$this->tugas->deadline->format('d M Y, H:i')}\n\n" .
                           "Segera kumpulkan tugas Anda!\n\n".
                           "Dashboard: " . "http://127.0.0.1:8000/Mahasiswa/login";
                $telegramService->sendMessage($mahasiswa->chat_id, $message);
            }
        }

        SendTugasNotification::dispatch($this->tugas)
            ->delay(now()->addMinutes($this->tugas->pengingat_interval));
    }
}
