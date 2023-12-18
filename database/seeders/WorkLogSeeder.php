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

        $admin = User::where('name', 'admin')->first();
        $staff = User::where('name', 'staff')->first();

        $generations = [];
        $dateGenerate = now();
        // for($i = 0; $i < 10; ++$i) {
        //     array_push($generations, array('created_at' => $dateGenerate->subMonth(), 'updated_at' => $dateGenerate->subMonth()));
        // }

        // Admin and Staff
        WorkLog::factory()->count(5)->for($admin, 'author')->for($workScopes[0])->hasRevisions(2)->hasImages(2)->create();
        WorkLog::factory()->count(5)
        ->sequence(['started_at' => $dateGenerate->subMonths(3), 'updated_at' => $dateGenerate])
        ->for($staff, 'author')->for($workScopes[0])->hasRevisions(2)->hasImages(2)->create();

        // foreach($workScopes as $workScope) {
        //     $user = User::inRandomOrder()->first();
        //     WorkLog::factory()->count(10)->for($user, 'author')->for($workScope)->hasRevisions(2)->hasImages(3)->create();
        //     WorkLog::factory()->count(10)->for($user, 'author')->for($workScope)->hasImages(3)->create();
        //     WorkLog::factory()->count(10)->for($user, 'author')->for($workScope)->create();
        // }

        // $users = User::factory()
        // ->count(10)
        // ->state(new Sequence(
        //     fn (Sequence $sequence) => ['role' => UserRoles::all()->random()],
        // ))
        // ->create();
    }
}
