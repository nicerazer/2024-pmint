<?php

namespace Database\Seeders;

use App\Models\WorkLog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (WorkLog::all() as $key => $value) {
            # code...
        }
    }
}
