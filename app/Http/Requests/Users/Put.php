<?php

namespace App\Http\Requests\Users;

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
            'bio' => 'string|nullable',
            'emoji_set' => [
                'string',
                Rule::in(['apple', 'google', 'twitter', 'emojione', 'messenger', 'facebook']),
            ],
            'name' => 'string',
        ];
    }

    public function attributes()
    {
        return [
            'bio' => '自己紹介',
            'emoji_set' => 'Emojiスキン',
            'name' => '名前',
        ];
    }
}
