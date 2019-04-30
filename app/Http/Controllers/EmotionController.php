<?php

namespace App\Http\Controllers;

class EmotionController extends Controller
{

    public function store(\App\Http\Requests\Emotions\Post $request)
    {
        $user = \Auth::user();
        $input = $request->only(['team_id', 'team_user_id', 'emoji', 'status_text', 'memo', 'entered_on']);
        $params = array_merge(['user_id' => $user->id], $input);

        if (!$this->isTeamExist($params['team_id'], $user->id)) {
            throw new \Exception('不正なアクセスです。');
        }

        return response(\App\Emotion::create($params), 201);
    }

    public function update(\App\Http\Requests\Emotions\Put $request, $emotionId)
    {
        $emotion = \App\Emotion::find($emotionId);
        $params = $request->only(['emoji', 'status_text', 'memo']);

        if (!$this->isTeamExist($emotion->team_id, $emotion->user_id)) {
            throw new \Exception('不正なアクセスです。');
        }

        $emotion->fill($params)->save();
        return response($emotion, 200);
    }

    private function isTeamExist($teamId, $userId) : bool
    {
        return \App\TeamUser::teamId($teamId)->userId($userId)->exists();
    }
}
