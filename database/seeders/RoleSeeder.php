<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Log::info('first: '. Role::count());

        Role::create(['title' => 'admin']);
        Role::create(['title' => 'staff']);
        Role::create(['title' => 'evaluator-1']);
        Role::create(['title' => 'evaluator-2']);
        Log::info('first: '. Role::count());
    }
}
