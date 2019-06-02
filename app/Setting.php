<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'team_user_settings';

    protected $fillable = [
        'team_user_id', 'key', 'value', 'type',
    ];

    public function teamUser()
    {
        return $this->belongsTo('App\TeamUser', 'team_user_id', 'id');
    }
}
