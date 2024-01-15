<?php

namespace App\Jobs;

use App\Models\TemporaryUpload;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\Attributes\WithoutRelations;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class TemporaryFileCleanup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        #[WithoutRelations]
        public TemporaryUpload $temporaryUpload
    ) {}

    /**
     * Execute the job.
     */
    public function handle(TemporaryUpload $temporaryUpload): void
    {
        // Delete Model
        $temporaryUpload->delete();
        // Delete temporary uploads
        Storage::delete('temporary-uploads/' . $temporaryUpload->file_name);
    }
}
