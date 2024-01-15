<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Log::info('=== === === === === === ===');
        Log::info('// Initiating seeding //');
        Log::info('=== === === === === === ===');
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        if (config('app')['debug'] && config('app')['env'] == 'local') {
            Storage::deleteDirectory('public/work-logs');
        }
        Storage::deleteDirectory('public/work-logs-test');

        $this->call([
            RoleSeeder::class,
            StaffSectionSeeder::class,
            WorkUnitSeeder::class,
            EvaluatorSeeder::class,
            UserSeeder::class,
            WorkScopeSeeder::class,
            WorkLogSeeder::class,
        ]);
    }
}
