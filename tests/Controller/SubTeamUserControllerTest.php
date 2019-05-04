<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SubTeamUserControllerTest extends TestCase
{
    use DatabaseTransactions;
    protected $subTeam;
    protected $user;

    public function setUp()
    {
        parent::setUp();
        $subTeamUser = \App\SubTeamUser::first();
        $subTeamUser->delete();
        $this->subTeam = $subTeamUser->subTeam;
        $this->user = $subTeamUser->user;
    }

    public function test_store_データ不備()
    {
        $params = [];
        $res = $this->actingAs($this->user, 'api')
            ->json('POST', "/api/v1/sub-team-users", $params);
        $res->assertStatus(422);
//        dd($res->baseResponse->getContent());
    }

    public function test_store_成功()
    {
        $params = [
            'sub_team_id' => $this->subTeam->id,
            'user_id' => $this->user->id,
        ];
        $res = $this->actingAs($this->user, 'api')
            ->json('POST', "/api/v1/sub-team-users", $params);
        $res->assertStatus(201);
//        dd($res->baseResponse->getContent());
    }
}
