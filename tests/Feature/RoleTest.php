<?php

namespace Tests\Feature;

use App\Helpers\UserRoleCodes;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\StaffSectionSeeder;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use DatabaseTruncation;

    public function test_user_without_a_role_redirects(): void
    {
        // Log::info('first: '. Role::count());
        $this->seed([
            RoleSeeder::class,
            StaffSectionSeeder::class,
        ]);
        // Log::info('first: '. Role::count());

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertRedirectToRoute('your-role-is-empty');
    }

    public function test_user_with_a_role_response_ok(): void
    {
        // Log::info('second: '. User::count());
        Log::info(DB::connection()->getDatabaseName());
        $this->seed();
        // Log::info('second: '. User::count());

        $user = User::factory()->create();
        $user->roles()->attach([UserRoleCodes::STAFF]);

        // Log::error(Role::count());
        // Log::info(User::first());
        // Log::info(User::first()->roles());
        // Log::info(User::first()->roles()->first());

        $response = $this->actingAs($user)->get('/');
        // $response = $this->get('/');

        $response->assertOk();
        // $response->assertRedirectToRoute('/');
    }
}
