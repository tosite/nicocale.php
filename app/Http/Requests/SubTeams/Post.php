<?php

namespace App\Http\Requests\SubTeams;

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
            'team_id' => 'required|string|exists:teams,id',
            'name' => 'required|string',
            'bio' => 'string|nullable',
        ];
    }

    public function attributes()
    {
        return [
            'team_id' => 'チームID',
            'name' => 'チーム名',
            'bio' => '概要',
        ];
    }
}
