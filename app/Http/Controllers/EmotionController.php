<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmotionController extends Controller
{
    const STORE_PARAMS = ['team_user_id', 'emoji', 'entered_on', 'status_text', 'memo'];

    public function store(Request $request)
    {
        $input     = $request->only(self::STORE_PARAMS);
        $team_user = \App\TeamUser::find($input['team_user_id']);
        $params    = $this->form_params($team_user, $input);
        $emotion   = \App\Emotion::createOrUpdateEmotion($params['keys'], $params['params']);
        return response()->json($emotion, 201);
    }

    public function destroy($id)
    {
        //
    }

    private function form_params($team_user, $input)
    {
        return [
            'keys' => [
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
