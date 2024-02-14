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

    public static function GETOPTIONS(): array {
        return [
            self::ALL => self::TRANSLATION[-1],
            self::ONGOING => self::TRANSLATION[0],
            self::SUBMITTED => self::TRANSLATION[1],
            self::TOREVISE => self::TRANSLATION[2],
            self::COMPLETED => self::TRANSLATION[3],
            self::CLOSED => self::TRANSLATION[4],
        ];
    }

    // public static function getTranslation() {
    //     return self::TRANSLATE;
    // }
}
