<?php

namespace Tests\Feature;

use App\Helpers\UserRoleCodes;
use App\Models\User;
use App\Models\WorkLog;
use Database\Seeders\RoleSeeder;
use Database\Seeders\StaffSectionSeeder;
use Database\Seeders\StaffUnitSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\EvaluatorSeeder;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubmissionTest extends TestCase
{
    use DatabaseTruncation;

    /**
     * A basic feature test example.
     */
    public function test_unassigned_evaluator_on_a_user_throws_exception_when_creating_worklog(): void
    {

        $this->seed([
            RoleSeeder::class,
            StaffSectionSeeder::class,
            StaffUnitSeeder::class,
            EvaluatorSeeder::class,
        ]);

        $user = User::factory()->create();
        $user->roles()->attach([UserRoleCodes::STAFF]);

        WorkLog::factory()->for($user, 'author')->create();

        // $response

        $response = $this->get('/login');

        $response->assertOk();
    }
}
