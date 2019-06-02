<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class EmotionController extends Controller
{

    public function store(\App\Http\Requests\Emotions\Post $request)
    {
        $user = \Auth::user();
        $input = $request->only(['team_id', 'team_user_id', 'emoji', 'score', 'status_text', 'memo', 'entered_on']);
        $params = array_merge(['user_id' => $user->id], $input);

        if (!$this->isTeamExist($params['team_id'], $user->id)) {
            throw new \Exception('不正なアクセスです。');
        }
        $emotion = \App\Emotion::create($params);
        $this->notifySlack($emotion, '登録');

        if ($emotion->teamUser->slack_access())
        {
            $this->setSlackStatus($emotion);
        }
        return response($emotion, 201);
    }

    public function update(\App\Http\Requests\Emotions\Put $request, $emotionId)
    {
        $emotion = \App\Emotion::find($emotionId);
        $params = $request->only(['emoji', 'score', 'status_text', 'memo']);

        if ($emotion->user_id !== \Auth::user()->id) {
            throw new \Exception('不正なアクセスです。');
        }

        $emotion->fill($params)->save();
        $this->notifySlack($emotion, '更新');

        if ($emotion->teamUser->slack_access())
        {
            $this->setSlackStatus($emotion);
        }
        return response($emotion, 200);
    }

    private function isTeamExist($teamId, $userId): bool
    {
        return \App\TeamUser::teamId($teamId)->userId($userId)->exists();
    }

    private function setSlackStatus($emotion)
    {
        $slack = $emotion->user->slack();
        $slack->usersProfileSet($emotion->status_text, $emotion->emoji);
    }

    private function notifySlack($emotion, $type)
    {
        if (empty($emotion->teamUser->notify_channel())) {
            return false;
        }

        $date = new Carbon($emotion->entered_on);
        $attachments = [
            'fallback' => "{$emotion->user->name}さんがニコカレを{$type}しました。",
            'text' => "{$emotion->user->name}さんがニコカレを{$type}しました。",
            'title' => $date->format('n月j日のカレンダーを見る'),
            'color' => $emotion->score()->get('color'),
            'title_link' => env('APP_URL', 'https://nicocale.app') . "/team-users/{$emotion->team_user_id}/calendars/{$date->format('Y/n')}",
            'fields' => [
                [
                    'title' => "感情（{$emotion->score()->get('name')}）",
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
        $slack->channel($emotion->teamUser->notify_channel())
            ->emoji($emotion->emoji)
            ->attachments($attachments)
            ->send();
    }
}
