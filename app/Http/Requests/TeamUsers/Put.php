<?php

namespace App\Http\Requests\TeamUsers;

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
            'notify_channel' => 'string|nullable',
        ];
    }

    public function attributes()
    {
        return [
            'notify_channel' => '通知チャンネル',
        ];
    }
}
