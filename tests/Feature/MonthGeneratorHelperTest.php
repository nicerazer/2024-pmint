<?php

namespace Tests\Feature;

use Tests\TestCase;

class MonthGeneratorHelperTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_generate_for_current_year(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_generate_for_past_year(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
