<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index ()
    {
        $team_users = \App\TeamUser::userId()->get();
        return view('teams/index', ['team_users' => $team_users]);
    }

//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function create ()
//    {
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store (Request $request)
    {
        $in         = $request->input();
        $slack_user = \App\Slack::usersInfo();
        \App\Team::createWithTeamUser(['name' => $in['name'], 'avatar' => 'png', 'slack_team_id' => $slack_user->team_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
//    public function show ($id)
//    {
//        $team      = \App\Team::find($id);
//        $team_user = \App\TeamUser::slackTeamId($team->slack_team_id)->get();
//        dd($team_user);
//    }

//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param  int $id
//     * @return \Illuminate\Http\Response
//     */
//    public function edit ($id)
//    {
//        //
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update (Request $request, $id)
    {
        $in        = $request->input();
        $t         = \App\Team::find($id);
        $t->name   = $in['name'] ?: $t->name;
        $t->avatar = $in['avatar'] ?: $t->avatar;
        $t->save();
    }

//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  int $id
//     * @return \Illuminate\Http\Response
//     */
//    public function destroy ($id)
//    {
//        //
//    }
}
