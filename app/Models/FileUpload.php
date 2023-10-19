<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class FileUpload extends Model
{
    use HasFactory;

    public function file_uploadables(): MorphTo
    {
        return $this->morphTo();
    }
}
