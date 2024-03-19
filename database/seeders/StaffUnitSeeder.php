<?php

namespace Database\Seeders;

use App\Models\StaffUnit;
use Illuminate\Database\Seeder;

class StaffUnitSeeder extends Seeder
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

        StaffUnit::upsert([
            ['name' => 'Perkhidmatan', 'staff_section_id' => 1],
            ['name' => 'Latihan & Kualiti', 'staff_section_id' => 1],
            ['name' => 'Perhubungan Korporat', 'staff_section_id' => 1],
            ['name' => 'Example Unit 1', 'staff_section_id' => 2],
            ['name' => 'Example Unit 2', 'staff_section_id' => 2],
        ], ['name', 'staff_section_id']);
    }
}
