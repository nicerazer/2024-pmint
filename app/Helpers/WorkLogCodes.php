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

    // public static function getTranslation() {
    //     return self::TRANSLATE;
    // }
}
