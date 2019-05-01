<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    public function update(\App\Http\Requests\Users\Put $request, $userId)
    {
        if (\Auth::user()->id !== $userId) {
            throw new \Exception('ユーザーIDが不正です。');
        }
        $params = $request->only(['bio', 'emoji_set']);
        $params['bio'] = empty($params['bio']) ? "" : $params['bio'];
        $user = \App\User::find($userId);
        $user->fill($params)->save();
        return response($user, 200);
    }
}
