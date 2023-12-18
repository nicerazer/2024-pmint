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
        StaffSection::create(['title' => 'Bahagian Pentadbiran & Sumber Manusia']);
        StaffSection::create(['title' => 'Sit amet marshmallow topping cheesecake muffin']);
        StaffSection::create(['title' => 'Stew and dumps taking the mick']);
        StaffSection::create(['title' => 'Danish fontina cheesy grin airedale']);
        StaffSection::create(['title' => 'Michael Knight a young loner']);
    }
}
