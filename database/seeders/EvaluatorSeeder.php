<?php

namespace Database\Seeders;

use App\Helpers\UserRoleCodes;
use App\Models\StaffSection;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EvaluatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $evaluator1 = User::create([
            'name' => 'evaluator-1',
            'ic' => 'evaluator-1-ic',
            'email' => 'evaluator-1@mail.com',
            'email_verified_at' => now(),
            'staff_unit_id' => 1,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $evaluator1->roles()->attach(UserRoleCodes::EVALUATOR_1);

        $evaluator2 = User::create([
            'name' => 'evaluator-2',
            'ic' => 'evaluator-2-ic',
            'email' => 'evaluator-2@mail.com',
            'email_verified_at' => now(),
            'staff_unit_id' => 1,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $evaluator2->roles()->attach(UserRoleCodes::EVALUATOR_2);

        StaffSection::where('id', 1)->update([
            'evaluator1_id' => $evaluator1->id,
            'evaluator2_id' => $evaluator2->id,
        ]);

    }
}
