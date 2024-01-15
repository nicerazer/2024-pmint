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
            'work_unit_id' => 1,
        ],
        [
            'title' => 'Lantik Jawatan Baru / Penempatan Warga Kerja',
            'work_unit_id' => 1,
        ],
        [
            'title' => 'Serah PGT',
            'work_unit_id' => 1,
        ],
        [
            'title' => 'Tuntut perbelanjaan kemudahan perubatan / rawatan',
            'work_unit_id' => 1,
        ],
        // Second
        [
            'title' => 'Urus keperluan latihan dalaman',
            'work_unit_id' => 2,
        ],
        [
            'title' => 'Urus keperluan latihan luaran',
            'work_unit_id' => 2,
        ],
        [
            'title' => 'Audit Dalam',
            'work_unit_id' => 2,
        ],
        [
            'title' => 'Audit Luar',
            'work_unit_id' => 2,
        ],
        [
            'title' => 'Urus program inovasi kreativiti',
            'work_unit_id' => 2,
        ],
        // Third
        [
            'title' => 'Urus penganjuran majlis jabatan',
            'work_unit_id' => 3,
        ],
        [
            'title' => 'Sedia informasi dan hebahan',
            'work_unit_id' => 3,
        ],
        [
            'title' => 'Urus aduan biasa, pertanyaan & kompleks pelanggan',
            'work_unit_id' => 3,
        ],
        ], ['title', 'work_unit_id']);
    }
}
