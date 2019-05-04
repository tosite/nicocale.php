<?php

namespace App\Http\Requests\SubTeamUsers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Post extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'sub_team_id' => 'required|string|exist:sub_teams,id',
        ];
    }

    public function attributes()
    {
        return [
            'sub_team_id' => 'チームID',
        ];
    }
}
