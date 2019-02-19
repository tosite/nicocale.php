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
        'name', 'avatar', 'team_id',
    ];

    public function team ()           { return $this->belongsTo('App\Team', 'team_id', 'id'); }
    public function sub_team_users () { return $this->hasMany('App\SubTeamUser', 'sub_team_id', 'id'); }
}
