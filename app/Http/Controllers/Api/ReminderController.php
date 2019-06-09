<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ReminderController extends Controller
{
    public function reminder()
    {
        $now = Carbon::now();
        $remindIds = $this->remindTeamUserIds($now);
        foreach ($remindIds as $teamUserId) {
            $teamUser = \App\TeamUser::find($teamUserId);
            if (empty($channel = $teamUser->notify_channel())) {
                continue;
            }

            if ($teamUser->skip_holiday() && ($now->isSaturday() || $now->isSunday())) {
                continue;
            }
            $slack = $teamUser->user->slackNotify();
            $slack->channel($channel)->attachments($this->attachments($teamUser))->send();
        }
        return response([
            'status' => 'ok',
            'ids' => $remindIds,
        ]);
    }

    private function attachments($teamUser)
    {
        return [
            'fallback' => "{$teamUser->user->name}さん、今日のキモチを教えてくれませんか？",
            'text' => "{$teamUser->user->name}さん、今日のキモチを教えてくれませんか？",
            'title' => 'キモチを登録する',
            'title_link' => env('APP_URL', 'https://nicocale.app') . "/teams/{$teamUser->team_id}",
        ];
    }

    private function remindTeamUserIds($now)
    {
        $teamUserIds = \App\Setting::where('key', 'remind_at')
            ->whereBetween('value', [
                // NOTE: バッチの実行時間の誤差を考慮し、±10分とする
                $now->copy()->subMinute(10)->format('H:i:s'),
                $now->copy()->addMinute(10)->format('H:i:s')
            ])
            ->get(['team_user_id'])
            ->pluck('team_user_id');

        $enteredTeamUserIds = \App\TeamUser::whereIn('team_user_id', $teamUserIds)
            ->leftJoin('emotions', 'team_users.id', '=', 'emotions.team_user_id')
            ->where('emotions.entered_on', '=', $now->format('Y-m-d'))
            ->get(['team_user_id'])
            ->pluck('team_user_id');

        return collect($teamUserIds)->diff($enteredTeamUserIds);
    }
}
