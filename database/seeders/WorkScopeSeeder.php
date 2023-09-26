<?php

namespace Database\Seeders;

use App\Models\WorkScope;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkScopeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WorkScope::upsert([
        [
            'title' => 'Isi Jawatan Baru',
            'unit' => 'Unit Perkhidmatan',
        ],
        [
            'title' => 'Lantik Jawatan Baru / Penempatan Warga Kerja',
            'unit' => 'Unit Perkhidmatsan',
        ],
        [
            'title' => 'Serah PGT',
            'unit' => 'Unit Perkhidmsatan',
        ],
        [
            'title' => 'Tuntut perbelanjaan kemudahan perubatan / rawatan',
            'unit' => 'Unit Perkhsidmatan',
        ],
        ], ['title', 'unit']);
    }
}
