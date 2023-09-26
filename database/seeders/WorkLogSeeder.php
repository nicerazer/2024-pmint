<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WorkLog;
use App\Models\WorkScope;
use Illuminate\Database\Seeder;

class WorkLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workScopes = WorkScope::all();

        $admin = User::where('name', 'super-admin')->first();

        WorkLog::factory()->count(5)->for($admin, 'author')->for($workScopes[0])->create();

        foreach($workScopes as $workScope) {
            $user = User::inRandomOrder()->first();
            WorkLog::factory()->count(100)->for($user, 'author')->for($workScope)->create();
        }
    }
}
