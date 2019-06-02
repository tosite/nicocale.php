<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TeamUserControllerTest extends TestCase
{
    use DatabaseTransactions;
    protected $teamUser;

    public function setUp(): void
    {
        parent::setUp();
        $this->teamUser = \App\TeamUser::first();
    }

    public function test_channel_データ不備()
    {
        $params = [
            'notify_channel' => '',
        ];
        $res = $this->actingAs($this->teamUser->user, 'api')
            ->json('PUT', "/api/v1/team-users/{$this->teamUser->id}/channels", $params);
        $res->assertStatus(422);
    }

    public function test_reminder_データ不備()
    {
        $params = [
            'remind_at' => '99:99:99',
        ];
        $res = $this->actingAs($this->teamUser->user, 'api')
            ->json('PUT', "/api/v1/team-users/{$this->teamUser->id}/reminders", $params);
        $res->assertStatus(422);
    }

    public function test_reminder_成功()
    {
        $params = [
            'remind_at' => '12:00:00',
            'skip_holiday' => false,
        ];
        $res = $this->actingAs($this->teamUser->user, 'api')
            ->json('PUT', "/api/v1/team-users/{$this->teamUser->id}/reminders", $params);
        $res->assertStatus(200);
    }

}
