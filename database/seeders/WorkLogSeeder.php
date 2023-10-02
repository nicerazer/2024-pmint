<?php

namespace Database\Seeders;

use App\Models\Revision;
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
        $test_staff = User::where('name', 'test_staff')->first();

        WorkLog::factory()->count(5)->for($admin, 'author')->for($workScopes[0])->hasRevisions(2)->create();
        WorkLog::factory()->count(5)->for($test_staff, 'author')->for($workScopes[0])->hasRevisions(2)->create();

        foreach($workScopes as $workScope) {
            $user = User::inRandomOrder()->first();
            WorkLog::factory()->count(100)->for($user, 'author')->for($workScope)->hasRevisions(2)->create();
        }
    }
}
