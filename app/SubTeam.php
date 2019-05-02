<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubTeam extends Model
{
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
        'name', 'team_id', 'bio',
    ];

    public function team ()         { return $this->belongsTo('App\Team', 'team_id', 'id'); }
    public function subTeamUsers () { return $this->hasMany('App\SubTeamUser', 'sub_team_id', 'id'); }

    public function scopeTeamId ($query, $teamId) { return $query->where(['team_id' => $teamId]); }

}
