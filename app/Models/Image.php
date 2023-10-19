<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function file_upload(): MorphMany
    {
        return $this->morphMany(FileUpload::class, 'file_uploadable');
    }

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getPath(): string
    {
        $imageable_type_in_plural = Str::plural($this->imageable_type);

        return "{$imageable_type_in_plural}/{$this->imageable_id}/{$this->name}.{$this->extension}";
    }
}
