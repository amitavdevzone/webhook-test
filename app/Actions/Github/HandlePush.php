<?php

namespace App\Actions\Github;

use Illuminate\Http\Request;

class HandlePush
{
    public function handle(Request $request)
    {
        $validator = validator($request->all(), [
            'head_commit.message' => 'required',
            'head_commit.author.name' => 'required',
        ]);

        if ($validator->fails()) {
            logger("Data has errors");
            logger($validator->errors());
            return false;
        }

        $data = $validator->validated();
        $message = "{$data['head_commit']['author']['name']} pushed with a commit message {$data['head_commit']['message']}";
        $author = $data['head_commit']['author']['name'];

        logger($message);
        return true;
    }
}
