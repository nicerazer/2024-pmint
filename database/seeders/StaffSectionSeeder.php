<?php

namespace Database\Seeders;

use App\Models\StaffSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StaffSection::create(['name' => 'Bahagian Pentadbiran & Sumber Manusia']);
    }
}
