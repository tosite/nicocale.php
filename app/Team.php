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

    public static function findOrCreateTeam ($slack_team)
    {
        $team         = \App\Team::firstOrNew(['slack_team_id' => $slack_team['id']]);
        $team->name   = $slack_team['name'];
        $team->avatar = $slack_team['image_230'];
        $team->save();
        return $team;
    }
}
