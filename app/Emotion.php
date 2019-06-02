<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Emotion extends Model
{
    use \App\Traits\Datable;

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
        'user_id', 'team_id', 'team_user_id', 'emoji',
        'score', 'status_text', 'memo', 'entered_on',
    ];

    const SCORE = [
        'good' => ['value' => 1, 'score' => 3, 'color' => '#66BB6A'],
        'soso' => ['value' => 2, 'score' => 2, 'color' => '#29B6F6'],
        'bad'  => ['value' => 3, 'score' => 1, 'color' => '#FFCA28'],
    ];

    public function score() {
        $score = \App\Emotion::SCORE;
        switch ($this->score) {
            case $score['good']['value']:
                return collect($score['good']);
            case $score['soso']['value']:
                return collect($score['soso']);
            case $score['bad']['value']:
                return collect($score['bad']);
            default:
                throw new \Exception("score didn't find.");
        }
    }

    public function team ()     { return $this->belongsTo('App\Team',     'team_id','id'); }
    public function user ()     { return $this->belongsTo('App\User',     'user_id','id'); }
    public function teamUser () { return $this->belongsTo('App\TeamUser', 'team_user_id','id'); }

    public function scopeTeamId ($query, $id)     { return $query->where(['team_id' => $id]); }
    public function scopeUserId ($query, $id)     { return $query->where(['user_id' => $id]); }
    public function scopeMe ($query)              { return $query->userId(\Auth::user()->id); }
    public function scopeTeamUserId ($query, $id) { return $query->where('team_user_id', $id); }

    public function scopeBetweenEnteredOn($query, $yyyymm) {
        $date_buf = strtotime("{$yyyymm}01");
        $query->whereBetween('entered_on', [date('Y-m-01', $date_buf), date('Y-m-t', $date_buf)]);
    }

}
