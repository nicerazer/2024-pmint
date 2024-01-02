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
            'Latihan & Kualiti',
            'Perhubungan Korporat',
            'Perkhidmatan',
        ];

        foreach ($units as $unit) {
            StaffUnit::create([
                'name' => 'Unit Perkhidmatan',
                'staff_section_id' => 1
            ]);
        }
    }
}
