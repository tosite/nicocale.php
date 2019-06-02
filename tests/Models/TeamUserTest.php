<?php

namespace Test\Models;

use App\TeamUser,
    Tests\TestCase,
    Illuminate\Foundation\Testing\DatabaseTransactions;

class TeamUserTest extends TestCase
{
    use DatabaseTransactions;

    protected $teamUser;

    public function setUp(): void
    {
        parent::setUp();
        $this->teamUser = TeamUser::create([
            'user_id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'team_id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
        ]);
    }

    public function test_slack_access()
    {
        $this->teamUser->slack_access(true);
        $this->assertTrue($this->teamUser->slack_access());
        $this->teamUser->slack_access(false);
        $this->assertFalse($this->teamUser->slack_access());
    }

    public function test_notify_channel()
    {
        $this->teamUser->notify_channel('channel');
        $this->assertSame('channel', $this->teamUser->notify_channel());
        $this->teamUser->notify_channel('new_channel');
        $this->assertSame('new_channel', $this->teamUser->notify_channel());
    }

    public function test_remind_at()
    {
        $this->teamUser->remind_at('12:00:00');
        $this->assertSame('12:00:00', $this->teamUser->remind_at());
        $this->teamUser->remind_at('13:00:00');
        $this->assertSame('13:00:00', $this->teamUser->remind_at());
    }

    public function test_skip_holiday()
    {
        $this->teamUser->skip_holiday(true);
        $this->assertTrue($this->teamUser->skip_holiday());
        $this->teamUser->skip_holiday(false);
        $this->assertFalse($this->teamUser->skip_holiday());
    }
}
