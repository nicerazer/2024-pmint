<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WorkLogTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_example(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }
}
