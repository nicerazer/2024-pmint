<?php

namespace Tests\Unit;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\StaffUnitSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RoleTest extends TestCase
{
   use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function test_user_without_a_role_redirects(): void
    {
        $this->seed([
            RoleSeeder::class,
            StaffUnitSeeder::class,
        ]);
        $user = User::factory()->create();

        Auth::login($user);

        $response = $this->actingAs($user)->get('/');

        if ($user->roles()->count() < 1)
            $response->assertRedirectToRoute('your-role-is-empty', $parameters = []);
        else
            $response->assertRedirect('/');
    }

    public function test_user_with_a_role_response_ok(): void
    {
        $this->seed([
            RoleSeeder::class,
            StaffUnitSeeder::class,
        ]);
        $user = User::factory()->create();
        $user->roles()->attach(1);

        Auth::login($user);

        $response = $this->actingAs($user)->get('/');

        $response->assertRedirectToRoute('home');
    }
}
