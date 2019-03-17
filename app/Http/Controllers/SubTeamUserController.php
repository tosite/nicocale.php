<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubTeamUserController extends Controller
{
    public function store($sub_team_id)
    {
        \App\SubTeamUser::findOrCreate($sub_team_id);
        return back();
    }

    public function destroy($id)
    {
        //
    }
}
