<?php

namespace App\Helpers;

class WorkLogCodes {
    public const ALL       = -1;
    public const ONGOING   = 0; // Dalam Tindakan
    public const SUBMITTED = 1; // Sedang Dinilai
    public const TOREVISE  = 2; // Kembali
    public const COMPLETED = 3; // Selesai
    public const CLOSED    = 4; // Batal

    public const TRANSLATION = [
        -1 => 'Semua',
        0 => 'Dalam Tindakan',
        1 => 'Sedang Dinilai',
        2 => 'Kembali',
        3 => 'Selesai',
        4 => 'Batal',
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
