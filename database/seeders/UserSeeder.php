<?php

namespace Database\Seeders;

use App\Helpers\UserRoleCodes;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'hr',
            'email' => 'hr@mail.com',
            'email_verified_at' => now(),
            'role' => UserRoleCodes::HR,
            'staff_unit_id' => 1,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'evaluator-1',
            'email' => 'evaluator-1@mail.com',
            'email_verified_at' => now(),
            'role' => UserRoleCodes::EVALUATOR_1,
            'staff_unit_id' => 1,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'evaluator-2',
            'email' => 'evaluator-2@mail.com',
            'email_verified_at' => now(),
            'role' => UserRoleCodes::EVALUATOR_2,
            'staff_unit_id' => 1,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'staff',
            'email' => 'staff@mail.com',
            'role' => UserRoleCodes::STAFF,
            'staff_unit_id' => 1,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        User::factory()->count(50)->create();
    }
}
