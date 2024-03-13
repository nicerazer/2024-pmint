<?php

namespace App\Livewire\WorkLogs\Show;

use App\Models\Submission;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\MediaStream;

class Documents extends Component
{
    public $submission;

    public function downloadDocuments() {
        $downloads = $this->submission->getMedia('documents');

        $zippedName = 'dokumen-aktiviti-' . $this->submission->worklog->id . '-serahan-' . $this->submission->id . '.zip';

        return MediaStream::create($zippedName)->addMedia($downloads);;
    }

    public function downloadDocument(Media $mediaItem) {
        return $mediaItem;
    }

    public function render()
    {
        return view('livewire.work-logs.show.documents');
    }
}
