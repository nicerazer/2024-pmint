<?php

namespace App\Livewire\WorkLogs\Show;

use App\Models\Submission;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\MediaStream;

class Images extends Component
{
    public $submission;

    public function downloadImages() {
        $downloads = $this->submission->getMedia('images');

        $zippedName = 'gambar-aktiviti-' . $this->submission->worklog->id . '-serahan-' . $this->submission->id . '.zip';

        return MediaStream::create($zippedName)->addMedia($downloads);;
    }

    public function downloadImage(Media $mediaItem) {
        return $mediaItem;
    }

    public function render()
    {
        return view('livewire.work-logs.show.images');
    }
}
