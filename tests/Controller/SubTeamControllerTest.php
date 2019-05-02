<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SubTeamControllerTest extends TestCase
{
    use DatabaseTransactions;
    protected $subTeamUser;
    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->subTeamUser = \App\SubTeamUser::first();
        $this->user = $this->subTeamUser->user;
    }

    public function test_store_データ不備()
    {
        $params = [
            'bio' => 'Hello, world!',
        ];
        $res = $this->actingAs($this->user, 'api')
            ->json('POST', "/api/v1/sub-teams", $params);
        $res->assertStatus(422);
//        dd($res->baseResponse->getContent());
    }

    public function test_store_成功()
    {
        $params = [
            'team_id' => $this->subTeamUser->team_id,
            'name' => 'test',
            'bio' => 'hello',
        ];
        $res = $this->actingAs($this->user, 'api')
            ->json('POST', "/api/v1/sub-teams", $params);
        $res->assertStatus(201);
    }

    public function test_update_データ不備()
    {
        $params = ['name' => null];
        $res = $this->actingAs($this->user, 'api')
            ->json('PUT', "/api/v1/sub-teams/{$this->subTeamUser->sub_team_id}", $params);
        $res->assertStatus(422);
    }
}
