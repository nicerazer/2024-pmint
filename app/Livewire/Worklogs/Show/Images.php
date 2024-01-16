<?php

namespace App\Livewire\WorkLogs\Show;

use App\Models\Submission;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\MediaStream;

class Images extends Component
{
    public $submission;

    public function downloadImages(Submission $submission) {
        $downloads = $submission->getMedia('images');

        $zippedName = 'logkerja-' . $submission->worklog->id . '-penyerahan-' . $submission->id . '.zip';

        return MediaStream::create($zippedName)->addMedia($downloads);;
    }

    public function downloadImage(Media $mediaItem) {
        return $mediaItem;
    }

    public function render()
    {
        return view('livewire.work-logs.show.images', [
            'submission' => $this->submission,
        ]);
    }
}
