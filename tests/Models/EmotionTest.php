<?php
namespace Test\Models;

use App\Emotion,
    Tests\TestCase,
    Illuminate\Foundation\Testing\DatabaseTransactions;

class EmotionTest extends TestCase
{
    use DatabaseTransactions;

    public function test_score_good()
    {
        $emotion = Emotion::first();
        $emotion->score = Emotion::SCORE['good']['value'];
        $emotion->save();
        $this->assertSame(Emotion::SCORE['good']['score'], $emotion->score()['score']);
    }

    public function test_score_soso()
    {
        $emotion = Emotion::first();
        $emotion->score = Emotion::SCORE['soso']['value'];
        $emotion->save();
        $this->assertSame(Emotion::SCORE['soso']['score'], $emotion->score()['score']);
    }

    public function test_score_bad()
    {
        $emotion = Emotion::first();
        $emotion->score = Emotion::SCORE['bad']['value'];
        $emotion->save();
        $this->assertSame(Emotion::SCORE['bad']['score'], $emotion->score()['score']);
    }
}
