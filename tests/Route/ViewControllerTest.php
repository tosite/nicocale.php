<?php

namespace Tests\Route;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewControllerTest extends TestCase
{

    /**
     * @test
     */
    public function teams_index(): void
    {
        $user = \App\User::first();
        $this->actingAs($user)
            ->get(route('teams.index'))
            ->assertViewIs('teams.index')
            ->assertStatus(200);
    }

    /**
     * @test
     */
    public function team_users_index(): void
    {
        $user = \App\User::first();
        $teamUser = \App\TeamUser::userId($user->id)->first();
        $this->actingAs($user)
            ->get(route('team_users.index', ['teamUserId' => $teamUser->team_id]))
            ->assertViewIs('team_users.index')
            ->assertStatus(200);
    }

    /**
     * @test
     */
    public function team_users_me_index(): void
    {
        $user = \App\User::first();
        $teamUser = \App\TeamUser::userId($user->id)->first();
        $this->actingAs($user)
            ->get(route('team_users.me', ['teamUserId' => $teamUser->id]))
            ->assertViewIs('team_users.me.index')
            ->assertStatus(200);
    }

    /**
     * @test
     */
    public function team_users_calendar_index(): void
    {
        $user = \App\User::first();
        $teamUser = \App\TeamUser::userId($user->id)->first();
        $this->actingAs($user)
            ->get(route('team_users.calendar', ['teamUserId' => $teamUser->id, 'year' => date('Y'), 'month' => date('n')]))
            ->assertViewIs('calendars.team_users.index')
            ->assertStatus(200);
    }

    /**
     * @test
     */
    public function team_users_list_index(): void
    {
        $user = \App\User::first();
        $teamUser = \App\TeamUser::userId($user->id)->first();
        $this->actingAs($user)
            ->get(route('team_users.list', ['teamUserId' => $teamUser->id, 'year' => date('Y'), 'month' => date('n')]))
            ->assertViewIs('lists.team_users.index')
            ->assertStatus(200);
    }

    /**
     * @test
     */
    public function sub_teams_calendar_index(): void
    {
        $user = \App\User::first();
        $subTeamUser = \App\SubTeamUser::userId($user->id)->first();
        $this->actingAs($user)
            ->get(route('sub_teams.calendar', ['subTeamId' => $subTeamUser->sub_team_id, 'year' => date('Y'), 'month' => date('n')]))
            ->assertViewIs('calendars.sub_teams.index')
            ->assertStatus(200);
    }

    /**
     * @test
     */
    public function sub_teams_list_index(): void
    {
        $user = \App\User::first();
        $subTeamUser = \App\SubTeamUser::userId($user->id)->first();
        $this->actingAs($user)
            ->get(route('sub_teams.list', ['subTeamId' => $subTeamUser->sub_team_id, 'year' => date('Y'), 'month' => date('n')]))
            ->assertViewIs('lists.sub_teams.index')
            ->assertStatus(200);
    }

    /**
     * @test
     */
    public function sub_teams_index(): void
    {
        $user = \App\User::first();
        $teamUser = \App\TeamUser::userId($user->id)->first();
        $this->actingAs($user)
            ->get(route('sub_teams.index', ['teamId' => $teamUser->team_id]))
            ->assertViewIs('sub_teams.index')
            ->assertStatus(200);
    }

    /**
     * @test
     */
    public function sub_teams_not_joined_index(): void
    {
        $user = \App\User::first();
        $teamUser = \App\TeamUser::userId($user->id)->first();
        $this->actingAs($user)
            ->get(route('sub_teams.not_joined', ['teamId' => $teamUser->team_id]))
            ->assertViewIs('sub_teams.not_joined.index')
            ->assertStatus(200);
    }

    /**
     * @test
     */
    public function sub_teams_setting_index(): void
    {
        $user = \App\User::first();
        $subTeamUser = \App\SubTeamUser::userId($user->id)->first();
        $this->actingAs($user)
            ->get(route('sub_teams.setting', ['subTeamId' => $subTeamUser->sub_team_id]))
            ->assertViewIs('sub_teams.settings.index')
            ->assertStatus(200);
    }

    /**
     * @test
     */
    public function sub_team_users_index(): void
    {
        $user = \App\User::first();
        $subTeamUser = \App\SubTeamUser::userId($user->id)->first();
        $this->actingAs($user)
            ->get(route('sub_team_users.index', ['subTeamId' => $subTeamUser->sub_team_id]))
            ->assertViewIs('sub_team_users.index')
            ->assertStatus(200);
    }

    /**
     * @test
     */
    public function sub_team_users_not_joined_index(): void
    {
        $user = \App\User::first();
        $subTeamUser = \App\SubTeamUser::userId($user->id)->first();
        $this->actingAs($user)
            ->get(route('sub_team_users.not_joined', ['subTeamId' => $subTeamUser->sub_team_id]))
            ->assertViewIs('sub_team_users.not_joined.index')
            ->assertStatus(200);
    }

    /**
     * @test
     */
    public function sub_team_users_me_index(): void
    {
        $user = \App\User::first();
        $subTeamUser = \App\SubTeamUser::userId($user->id)->first();
        $this->actingAs($user)
            ->get(route('sub_team_users.me', ['subTeamUserId' => $subTeamUser->id]))
            ->assertViewIs('sub_team_users.me.index')
            ->assertStatus(200);
    }
}
