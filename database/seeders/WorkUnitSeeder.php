<?php

namespace Database\Seeders;

use App\Models\WorkUnit;
use Illuminate\Database\Seeder;

class WorkUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            'Perkhidmatan',
            'Latihan & Kualiti',
            'Perhubungan Korporat',
        ];

        WorkUnit::upsert([
            ['name' => 'Perkhidmatan', 'staff_section_id' => 1],
            ['name' => 'Latihan & Kualiti', 'staff_section_id' => 1],
            ['name' => 'Perhubungan Korporat', 'staff_section_id' => 1],
        ], ['name', 'staff_section_id']);
    }
}
