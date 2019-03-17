<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubTeamController extends Controller
{
    use \App\Traits\Datable;

    const STORE_PARAMS = ['name', 'avatar'];

    public function store(Request $request, $teamId)
    {
        $input    = $request->only(self::STORE_PARAMS);
        $teamUser = \App\TeamUser::findByTeamId($teamId);
        $subTeam  = \App\SubTeam::create(['name' => $input['name'] ,'team_id' => $teamId,'avatar' => '']);
        \App\SubTeamUser::create([
            'team_id'      => $teamId,
            'team_user_id' => $teamUser->id,
            'sub_team_id'  => $subTeam->id,
        ]);
        return back();
    }

    public function show($sub_team_id, $yyyymm)
    {
        $sub_team      = \App\SubTeam::find($sub_team_id);
        $team_user_ids = [];
        foreach($sub_team->subTeamUsers as $s) { $team_user_ids[] = $s->team_user->id; }
        $emotions       = \App\Emotion::betweenEnteredOn($yyyymm)->teamUserId($team_user_ids)->getKeyBy();
        $sub_team_users = \App\SubTeamUser::subTeamId($sub_team_id)->get();
        $date_list      = $this->createDateList($yyyymm);
        $teamList       = \App\Services\Navigations::sideNav();
        return view('sub_teams/show', array_merge($teamList, [
            'user_id'        => \Auth::user()->id,
            'sub_team_users' => $sub_team_users,
            'sub_team'       => \App\SubTeam::find($sub_team_id),
            'emotions'       => $emotions,
            'date_list'      => $date_list,
            'day_of_weeks'   => $this->dayOfWeeks(),
            'months'         => $this->createMonthsList($yyyymm),
        ]));
    }

    public function update(Request $request, $subTeamId)
    {
        $input = $request->only(self::STORE_PARAMS);
        $subTeam = \App\SubTeam::find($subTeamId);
        $subTeam->fill($input);
        $subTeam->save();
        return back();
    }

    public function destroy($id)
    {
        //
    }
}
