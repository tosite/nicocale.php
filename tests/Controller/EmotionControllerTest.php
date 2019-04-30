<?php

namespace Tests\Feature;

use Mockery\Exception;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EmotionControllerTest extends TestCase
{
    use DatabaseTransactions;
    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = \App\User::first();
    }

    public function test_store_データ不備()
    {
        $params = [
            'team_id' => $this->user->id,
        ];

        $this->actingAs($this->user, 'api')
            ->json('POST', '/emotions', $params)
            ->assertStatus(422);
    }

    public function test_store_新規データ()
    {
        $emotion = \App\Emotion::userId($this->user->id)->first();
        $params = [
            'team_id' => $emotion->team_id,
            'team_user_id' => $emotion->team_user_id,
            'emoji' => ':smile:',
            'status_text' => 'happy',
            'memo' => $emotion->memo,
            'entered_on' => '2000-01-01',
        ];

        $this->actingAs($this->user, 'api')
            ->json('POST', '/emotions', $params)
            ->assertStatus(201);
    }

    public function test_store_すでに存在しているデータ()
    {
        $emotion = \App\Emotion::userId($this->user->id)->first();
        $params = [
            'team_id' => $emotion->team_id,
            'team_user_id' => $emotion->team_user_id,
            'emoji' => $emotion->emoji,
            'status_text' => $emotion->status_text,
            'memo' => $emotion->memo,
            'entered_on' => $emotion->entered_on,
        ];
        $this->actingAs($this->user, 'api')
            ->json('POST', '/emotions', $params)
            ->assertStatus(500);
//        dd($res->baseResponse->getContent());
    }

    public function test_store_他のユーザーとして投稿する()
    {
        $emotion = \App\Emotion::where('user_id', '!=', $this->user->id)->first();
        $params = [
            'team_id' => $emotion->team_id,
            'team_user_id' => $emotion->team_user_id,
            'emoji' => $emotion->emoji,
            'status_text' => $emotion->status_text,
            'memo' => $emotion->memo,
            'entered_on' => $emotion->entered_on,
        ];
        $this->actingAs($this->user, 'api')
            ->json('POST', '/emotions', $params)
            ->assertStatus(500);
    }

    public function test_update_データ不備()
    {
        $emotion = \App\Emotion::userId($this->user->id)->first();
        $params = [];

        $this->actingAs($this->user, 'api')
            ->json('PUT', "/emotions/{$emotion->id}", $params)
            ->assertStatus(422);
    }

    public function test_update_成功()
    {
        $emotion = \App\Emotion::userId($this->user->id)->first();
        $params = [
            'emoji' => $emotion->emoji,
            'status_text' => $emotion->status_text,
            'memo' => $emotion->memo,
        ];
        $this->actingAs($this->user, 'api')
            ->json('PUT', "/emotions/{$emotion->id}", $params)
            ->assertStatus(200)
        ;
    }

    public function test_update_余計なパラメータがあるが成功()
    {
        $emotion = \App\Emotion::userId($this->user->id)->first();
        $params = [
            'emoji' => $emotion->emoji,
            'status_text' => $emotion->status_text,
            'memo' => $emotion->memo,
            'entered_on' => '1990-05-01',
        ];
        $this->actingAs($this->user, 'api')
            ->json('PUT', "/emotions/{$emotion->id}", $params)
            ->assertStatus(200);
    }

    public function test_update_他のユーザーとして投稿する()
    {
        $me = \App\TeamUser::userId($this->user->id)->first();
        $emotion = \App\Emotion::where('user_id', '!=', $this->user->id)->first();
        $params = [
            'emoji' => $emotion->emoji,
            'status_text' => $emotion->status_text,
            'memo' => $emotion->memo,
        ];
        $this->actingAs($this->user, 'api')
            ->json('PUT', "/emotions/{$emotion->id}", $params)
            ->assertStatus(500);
    }
}
