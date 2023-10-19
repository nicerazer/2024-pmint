<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
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
            UserSeeder::class,
            WorkScopeSeeder::class,
            WorkLogSeeder::class,
            ImageSeeder::class,
        ]);
    }
}
