<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

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
        $emotion = \App\Emotion::create($params);
        $this->notifySlack($emotion, '登録');
        return response($emotion, 201);
    }

    public function update(\App\Http\Requests\Emotions\Put $request, $emotionId)
    {
        $emotion = \App\Emotion::find($emotionId);
        $params = $request->only(['emoji', 'status_text', 'memo']);

        if ($emotion->user_id !== \Auth::user()->id) {
            throw new \Exception('不正なアクセスです。');
        }

        $emotion->fill($params)->save();
        $this->notifySlack($emotion, '更新');
        return response($emotion, 200);
    }

    private function isTeamExist($teamId, $userId): bool
    {
        return \App\TeamUser::teamId($teamId)->userId($userId)->exists();
    }

    private function notifySlack($emotion, $type)
    {
        if (empty($emotion->teamUser->notify_channel)) {
            return false;
        }

        $date = new Carbon($emotion->entered_on);
        $attachments = [
            'fallback' => "{$emotion->user->name}さんがニコカレを{$type}しました。",
            'text' => "{$emotion->user->name}さんがニコカレを{$type}しました。",
            'title' => $date->format('Y年n月j日のカレンダーを見る'),
            'color' => 'good',
            'title_link' => env('APP_URL') . "/team-users/{$emotion->team_user_id}/calendars/{$date->format('Y/n')}",
            'author_name' => $emotion->user->name,
            'fields' => [
                [
                    'title' => '感情',
                    'value' => $emotion->emoji,
                    'short' => true,
                ],
                [
                    'title' => 'ひとこと',
                    'value' => $emotion->status_text,
                    'short' => true,
                ],
            ],
        ];

        $slack = $emotion->user->slackNotify();
        $slack->channel($emotion->teamUser->notify_channel)
            ->emoji($emotion->emoji)
            ->attachments($attachments)
            ->send();
    }
}
