<?php

namespace App\Http\Controllers;

class SubTeamController extends Controller
{

    public function store(\App\Http\Requests\SubTeams\Post $request)
    {
        $params = $request->only(['team_id', 'name', 'bio']);
        $params['bio'] = empty($params['bio']) ? '' : $params['bio'];
        return response(\App\SubTeam::create($params), 201);
    }


    public function update(\App\Http\Requests\SubTeams\Put $request, $subTeamId)
    {
        $params = $request->only(['name', 'bio']);
        $subTeam = \App\SubTeam::find($subTeamId);
        if ($request->input()['team_id'] != $subTeam->team_id) {
            throw new \Exception('不正な操作です。');
        }
        $subTeam->fill($params)->save();
        return $subTeam;
    }
}
