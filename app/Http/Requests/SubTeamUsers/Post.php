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
            'sub_team_id' => 'required|string|exists:sub_teams,id',
            'user_id' => 'required|string|exists:users,id',
        ];
    }

    public function attributes()
    {
        return [
            'sub_team_id' => 'チームID',
            'user_id' => 'ユーザーID',
        ];
    }
}
