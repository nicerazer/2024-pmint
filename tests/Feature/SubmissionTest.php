<?php

namespace Tests\Feature;

use Database\Seeders\RoleSeeder;
use Database\Seeders\StaffSectionSeeder;
use Database\Seeders\StaffUnitSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\EvaluatorSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubmissionTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_unassigned_evaluator_on_user_throws_exception(): void
    {
        $this->seed([
            RoleSeeder::class,
            StaffSectionSeeder::class,
            StaffUnitSeeder::class,
            EvaluatorSeeder::class,
        ]);

        User::factory()->

        // $response

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
