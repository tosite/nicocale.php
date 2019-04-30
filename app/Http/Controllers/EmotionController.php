<?php

namespace App\Http\Controllers;

class EmotionController extends Controller
{

    public function store(\App\Http\Requests\Emotions\Post $request)
    {
        $user = \AUth::user();
        $params = array_merge(['user_id' => $user->id], $request->input());
        return response(\App\Emotion::create($params), 201);
    }

    public function update(\App\Http\Requests\Emotions\Put $request, $emotionId)
    {
    }
}
