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
        $user = \App\User::where('id', '!=', $this->user->id)->first();
        $res = $this->actingAs($this->user, 'api')
            ->json('POST', "/api/v1/sub-teams", $params);
        $res->assertStatus(422);
//        dd($res->baseResponse->getContent());
    }
}
