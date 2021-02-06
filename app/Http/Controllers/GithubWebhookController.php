<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\Github\HandlePush;
use App\Actions\Github\HandleComment;

class GithubWebhookController extends Controller
{
    public function index(Request $request)
    {
        $header = $request->header('X-Github-Event');

        $handlers = [
            'issue_comment' => HandleComment::class,
            'push' => HandlePush::class,
        ];

        if (!isset($handlers[$request->header('X-Github-Event')])) {
            return false;
        }

        app()->make($handlers[$request->header('X-Github-Event')])
            ->handle($request);

        return true;
    }
}
