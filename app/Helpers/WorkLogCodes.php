<?php

namespace App\Helpers;

class WorkLogCodes {
    public const ALL       = -1;
    public const ONGOING   = 0; // Dalam Tindakan
    public const SUBMITTED = 1; // Sedang Dinilai
    public const TOREVISE  = 2; // Kembali
    public const COMPLETED = 3; // Selesai Evaluator 1
    public const CLOSED    = 4; // Batal
    public const REVIEWED  = 5; // Selesai Evaluator 2
    public const NOTYETEVALUATED  = 6; // Belum Selesai Evaluator 1

    public const TRANSLATION = [
        -1 => 'Semua',
        0 => 'Dalam Tindakan',
        1 => 'Sedang Dinilai',
        2 => 'Kembali',
        3 => 'Disahkan (Penilai 1)',
        4 => 'Batal',
        5 => 'Disahkan (Penilai 2)',
        // 5 => 'Disahkan (Penilai 2)',
    ];

    public static function GETTRANSLATION($status): string {
        return [
            -1 => 'Semua',
            0 => 'Dalam Tindakan',
            1 => auth()->user()->isStaff() ? 'Sedang Dinilai' : 'Untuk Penilaian',
            2 => 'Kembali',
            3 => 'Disahkan (Penilai 1)',
            4 => 'Batal',
            5 => 'Disahkan (Penilai 2)',
            // 5 => 'Disahkan (Penilai 2)',
        ][$status];
    }

    public static function GETOPTIONS(): array {
        if (auth()->user()->isEvaluator2() == UserRoleCodes::EVALUATOR_2)
            return [
                self::COMPLETED => self::TRANSLATION[self::COMPLETED],
                self::REVIEWED => self::TRANSLATION[self::REVIEWED],
            ];

        return [
            self::ALL => self::TRANSLATION[self::ALL],
            self::ONGOING => self::TRANSLATION[self::ONGOING],
            self::SUBMITTED => self::TRANSLATION[self::SUBMITTED],
            self::TOREVISE => self::TRANSLATION[self::TOREVISE],
            self::COMPLETED => self::TRANSLATION[self::COMPLETED],
            self::CLOSED => self::TRANSLATION[self::CLOSED],
        ];
    }

    // public static function getTranslation() {
    //     return self::TRANSLATE;
    // }
}
