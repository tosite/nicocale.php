<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
