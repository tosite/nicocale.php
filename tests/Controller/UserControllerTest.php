<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions;
    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = \App\User::first();
    }

    public function test_update_データ不備()
    {
        $params = [
            'emoji_set' => 'undefined',
        ];

        $res = $this->actingAs($this->user, 'api')
            ->json('PUT', "/api/v1/users/{$this->user->id}", $params);
        $res->assertStatus(422);
    }
}
