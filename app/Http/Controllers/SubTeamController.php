<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubTeamController extends Controller
{
    use \App\Traits\Datable;

    const STORE_PARAMS = ['name', 'avatar', 'team_user_id'];

    public function store(Request $request)
    {
        $input     = $request->only(self::STORE_PARAMS);
        $team_user = \App\TeamUser::find($input['team_user_id']);
        $sub_team  = \App\SubTeam::create([
            'team_id' => $team_user->team->id,
            'name'    => $input['name'],
            'avatar'  => '',
        ]);

        return \App\SubTeamUser::findOrCreate($team_user->team->id, $sub_team->id, $team_user->id);
    }

    public function show($sub_team_id, $yyyymm)
    {
        $sub_team      = \App\SubTeam::find($sub_team_id);
        $team_user_ids = [];
        foreach($sub_team->sub_team_users as $s) { $team_user_ids[] = $s->team_user->id; }
        $emotions       = \App\Emotion::betweenEnteredOn($yyyymm)->teamUserId($team_user_ids)->getKeyBy();
        $sub_team_users = \App\SubTeamUser::subTeamId($sub_team_id)->get();
        $date_list      = $this->createDateList($yyyymm);
        return view('sub_teams/show', [
            'user_id'        => \Auth::user()->id,
            'sub_team_users' => $sub_team_users,
            'sub_team'       => \App\SubTeam::find($sub_team_id),
            'emotions'       => $emotions,
            'date_list'      => $date_list,
            'day_of_weeks'   => $this->dayOfWeeks(),
            'months'         => $this->createMonthsList($yyyymm),
        ]);
    }

    public function update(Request $request, $sub_team_id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
