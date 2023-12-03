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
            'staff_unit_id' => 1,
        ],
        [
            'title' => 'Lantik Jawatan Baru / Penempatan Warga Kerja',
            'staff_unit_id' => 1,
        ],
        [
            'title' => 'Serah PGT',
            'staff_unit_id' => 1,
        ],
        [
            'title' => 'Tuntut perbelanjaan kemudahan perubatan / rawatan',
            'staff_unit_id' => 1,
        ],
        ], ['title', 'staff_unit_id']);
    }
}
