<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
            'name', 'avatar', 'slack_team_id',
    ];

    public function teamUsers ()
    {
        return $this->hasMany('App\TeamUser', 'slack_team_id', 'slack_team_id');
    }

    public static function findOrCreateTeam ($slack_team)
    {
        $team         = \App\Team::firstOrNew(['slack_team_id' => $slack_team['id']]);
        $team->name   = $slack_team['name'];
        $team->avatar = $slack_team['image_230'];
        $team->save();
        return $team;
    }
}
