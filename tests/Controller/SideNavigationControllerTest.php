<?php

namespace Tests\Controller;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SideNavigationControllerTest extends TestCase
{

    /**
     * @test
     */
    public function teams_index(): void
    {
        $user = \App\User::first();
        $teamIds = \App\TeamUser::userId($user->id)->pluck('team_id')->toArray();
        $teams = \App\Team::whereIn('id', $teamIds)->get(['id', 'avatar', 'name'])->toArray();
        $expect = [
            'user' => $user->only(['name', 'avatar']),
            'teams' => $teams,
            'currentTeam' => $teams[0],
            'subTeams' => \App\SubTeam::teamId($teamIds[0])->get(['id', 'team_id', 'avatar', 'name'])->toArray(),
        ];

        $res = $this->actingAs($user, 'api')
            ->json('GET', route('api_side_navigations.index'));

        $res->assertStatus(200)
            ->assertJson($expect);
    }

}
