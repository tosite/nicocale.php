<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Team extends Model
{

    // プライマリーキーの型
    protected $keyType = 'string';

    // プライマリーキーは自動連番か？
    public $incrementing = false;

    // コンストラクタを追加
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->attributes['id'] = Str::orderedUuid();
    }


    protected $fillable = [
            'name', 'avatar', 'slack_team_id',
    ];

    public function teamUsers ()
    {
        return $this->hasMany('App\TeamUser', 'slack_team_id', 'slack_team_id');
    }

    public static function createWithTeamUser ($params)
    {
        $team = \App\Team::create($params);
        \App\TeamUser::create(['oauth_id' => \Auth::user()->oauth_id, 'slack_team_id' => $team->slack_team_id, 'team_id' => $team->id]);
    }
}
