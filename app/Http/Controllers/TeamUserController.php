<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamUserController extends Controller
{
    public function update(\App\Http\Requests\TeamUsers\Put $request, $teamUserId)
    {
        $params = $request->only(['notify_channel']);
        $teamUser = \App\TeamUser::find($teamUserId);
        $teamUser->fill($params)->save();
        $user = \Auth::user();
        $user->slack()->chatPostMessage($teamUser->notify_channel, $user->name.'さんがチャンネル通知を設定しました。');
        return response($teamUser, 200);
    }
}
