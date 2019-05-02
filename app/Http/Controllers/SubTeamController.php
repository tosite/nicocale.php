<?php

namespace App\Http\Controllers;

class SubTeamController extends Controller
{

    public function store(\App\Http\Requests\SubTeams\Post $request)
    {
        $params = $request->only(['team_id', 'name', 'bio']);
        return response(\App\SubTeam::create($params), 201);
    }


    public function update(\App\Http\Requests\SubTeams\Put $request, $subTeamId)
    {
    }
}
