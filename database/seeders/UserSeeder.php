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
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'email_verified_at' => now(),
            'staff_section_id' => 1,
            'staff_unit_id' => 1,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $admin->roles()->attach([UserRoleCodes::ADMIN, UserRoleCodes::STAFF, UserRoleCodes::EVALUATOR_1, UserRoleCodes::EVALUATOR_2,]);


        $user2 = User::create([
            'name' => 'evaluator-1',
            'email' => 'evaluator-1@mail.com',
            'email_verified_at' => now(),
            'staff_section_id' => 1,
            'staff_unit_id' => 1,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $user2->roles()->attach([UserRoleCodes::STAFF]);

        $user3 = User::create([
            'name' => 'evaluator-2',
            'email' => 'evaluator-2@mail.com',
            'email_verified_at' => now(),
            'staff_section_id' => 1,
            'staff_unit_id' => 1,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $user3->roles()->attach([UserRoleCodes::ADMIN,UserRoleCodes::STAFF]);

        $userStaff = User::create([
            'name' => 'staff',
            'email' => 'staff@mail.com',
            'staff_section_id' => 1,
            'staff_unit_id' => 1,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $userStaff->roles()->attach([UserRoleCodes::STAFF]);

        User::factory()->count(50)->create();
    }
}
