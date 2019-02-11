<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmotionController extends Controller
{
    const STORE_PARAMS = ['emoji', 'entered_on', 'status_text', 'memo'];

    public function store (Request $request, $team_id)
    {
        $input     = $request->only(self::STORE_PARAMS);
        $team_user = \App\TeamUser::findByTeamId($team_id);
        $params    = $this->form_params($team_user, $input);
        \App\Emotion::createEmotion($params['keys'], $params['params']);
        return redirect()->back();
    }

    public function update (Request $request, $id)
    {
        //
    }

    public function destroy ($id)
    {
        //
    }

    private function form_params ($team_user, $input)
    {
        return [
            'keys'   => [
                'user_id'    => $team_user->user->id,
                'team_id'    => $team_user->team->id,
                'entered_on' => $input['entered_on'],
            ],
            'params' => [
                'team_user_id' => $team_user->id,
                'status_text'  => $input['status_text'],
                'emoji'        => $input['emoji'],
                'memo'         => $input['memo'],
            ],
        ];
    }
}
