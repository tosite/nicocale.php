<?php

namespace App\Http\Controllers;

class SlackNotifyController extends Controller
{
    public function test($cannel)
    {
        $user = \Auth::user();
        return $user->slack()->chatPostMessage($cannel, "テストメッセージです。 - {$user->name}さんが送信");

    }
}
