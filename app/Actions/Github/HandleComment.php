<?php

namespace App\Actions\Github;

use Illuminate\Http\Request;
use App\Actions\Discord\SendDiscordNotification;

class HandleComment
{
    public function handle(Request $request)
    {
        $validator = validator($request->all(), [
            'action' => 'required',
            'issue.title' => 'required',
            'comment.user.login' => 'required',
            'comment.html_url' => 'required',
        ]);

        if ($validator->fails()) {
            logger("Data has errors");
            logger($validator->errors());
            return false;
        }

        $data = $validator->validated();
        $message = "{$data['comment']['user']['login']} commented on ticket '{$data['issue']['title']}'. Click here to read {$data['comment']['html_url']}";
        $author = $data['comment']['user']['login'];

        logger($message);

        app()->make(SendDiscordNotification::class)->handle($message, $author);
        return true;
    }
}
