<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class TelegramService
{
    protected $botToken;

    public function __construct()
    {
        $this->botToken = config('services.telegram.bot_token');
    }

    public function sendMessage($chatId, $message)
{
    $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";

    return Http::withoutVerifying()->post($url, [
        'chat_id' => $chatId,
        'text' => $message,
    ]);
}

}
