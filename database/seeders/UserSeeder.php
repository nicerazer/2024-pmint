<?php

namespace Database\Seeders;

use App\Helpers\UserRoleCodes;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
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
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $admin->roles()->attach([UserRoleCodes::ADMIN, UserRoleCodes::STAFF]);

        $userStaff = User::create([
            'name' => 'staff',
            'email' => 'staff@mail.com',
            'staff_section_id' => 1,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $userStaff->roles()->attach([UserRoleCodes::STAFF]);

        Log::info("From DB: " . Role::find(UserRoleCodes::EVALUATOR_1));
        // Log::info("From DB: " . Role::find(UserRoleCodes::EVALUATOR_1)->users()->first()->id);
        // die();

        $evaluator1 = Role::find(UserRoleCodes::EVALUATOR_1)->users()->first();
        $evaluator2 = Role::find(UserRoleCodes::EVALUATOR_2)->users()->first();

        $admin->evaluator1_id = $evaluator1->id;
        $admin->evaluator2_id = $evaluator2->id;
        $admin->save();

        $userStaff->evaluator1_id = $evaluator1->id;
        $userStaff->evaluator2_id = $evaluator2->id;
        $userStaff->save();

        // User::factory()->count(50)->create();
    }
}
