<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'team_user_settings';
    public $incrementing = false;
    protected $primaryKey = 'team_user_id';

    protected $fillable = [
        'team_user_id', 'key', 'value', 'type',
    ];

    public function teamUser()
    {
        return $this->belongsTo('App\TeamUser', 'team_user_id', 'id');
    }

    public function value()
    {
        switch ($this->type) {
            case 'bool':
                return (bool) $this->value;
            case 'int':
                return (int) $this->value;
            case 'string':
                return (string) $this->value;
            case 'float':
                return (float) $this->value;
            case 'array':
                return (array) $this->value;
            case 'object':
                return (object) $this->value;
        }
    }
}
