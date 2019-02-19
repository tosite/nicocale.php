<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Team extends Model
{
    use \App\Traits\Findable;

    // プライマリキー
    protected $keyType      = 'string';
    public    $incrementing = false;

    // コンストラクタを追加
    public function __construct (array $attributes = [])
    {
        parent::__construct($attributes);
        $this->attributes['id'] = Str::orderedUuid();
    }


    protected $fillable = [
            'name', 'avatar', 'slack_team_id',
    ];

    public function teamUsers () { return $this->hasMany('App\TeamUser', 'team_id', 'id'); }
    public function emotions ()  { return $this->hasMany('App\Emotion',  'team_id', 'id'); }
    public function subTeams ()  { return $this->hasMany('App\SubTeam',  'team_id', 'id'); }

    public static function findOrCreateTeam ($slack_team)
    {
        $team         = \App\Team::firstOrNew(['slack_team_id' => $slack_team['id']]);
        $team->name   = $slack_team['name'];
        $team->avatar = $slack_team['image_230'];
        $team->save();
        return $team;
    }

    public static function teamList ()
    {
        $team_list  = [];
        foreach (\App\TeamUser::userId()->get() as $t) {
            $team_list[$t->id]['team'] = [
                'id'     => $t->team->id,
                'name'   => $t->team->name,
                'avatar' => $t->team->avatar,
            ];

            $team_list[$t->id]['sub_teams'] = [];
            foreach (\App\SubTeamUser::teamUserId($t->id)->get() as $s) {
                $team_list[$t->id]['sub_teams'][] = [
                    'id'     => $s->sub_team->id,
                    'name'   => $s->sub_team->name,
                    'avatar' => $s->sub_team->avatar,
                ];
            }
        }
        return $team_list;
    }
}
