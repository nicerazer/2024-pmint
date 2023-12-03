<?php

namespace Database\Seeders;

use App\Models\StaffSection;
use App\Models\StaffUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staffsection = StaffSection::create(
            [
            'name' => 'Unit Perkhidmatan'
        ]);

        StaffUnit::create([
            'name' => 'Unit Perkhidmatan',
            'staff_section_id' => $staffsection->id,
        ]);

        // StaffSection::create([
        //     'name' => 'Bahagian Infostruktur'
        // ])->for(

        // );

        // StaffUnit::create([
        //     'name' => 'Unit Kesihatan',
        // ])->has(StaffSection::make([
        //     'name' => 'Bahagian Klinik'
        // ]));
    }
}
