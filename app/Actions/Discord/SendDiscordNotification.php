<?php

namespace App\Actions\Discord;

use Illuminate\Support\Facades\Http;

class SendDiscordNotification
{
    public function handle($message, $author)
    {
        $data = [
            'content' => $message,
            'username' => $author,
        ];

        try {
            Http::post(\config('app.discord_webhook_url'), $data);
        } catch (\Exception $e) {
            logger($e->getMessage());
        }
    }
}
