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
        // Second
        [
            'title' => 'Urus keperluan latihan dalaman',
            'staff_unit_id' => 2,
        ],
        [
            'title' => 'Urus keperluan latihan luaran',
            'staff_unit_id' => 2,
        ],
        [
            'title' => 'Audit Dalam',
            'staff_unit_id' => 2,
        ],
        [
            'title' => 'Audit Luar',
            'staff_unit_id' => 2,
        ],
        [
            'title' => 'Urus program inovasi kreativiti',
            'staff_unit_id' => 2,
        ],
        // Third
        [
            'title' => 'Urus penganjuran majlis jabatan',
            'staff_unit_id' => 3,
        ],
        [
            'title' => 'Sedia informasi dan hebahan',
            'staff_unit_id' => 3,
        ],
        [
            'title' => 'Urus aduan biasa, pertanyaan & kompleks pelanggan',
            'staff_unit_id' => 3,
        ],
        ], ['title', 'staff_unit_id']);
    }
}
