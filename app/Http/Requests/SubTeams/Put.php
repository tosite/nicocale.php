<?php

namespace App\Http\Requests\SubTeams;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Put extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'string',
            'bio' => 'string|nullable',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'チーム名',
            'bio' => '概要',
        ];
    }
}
