<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\WorkLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;

class WorkLogDocumentController extends Controller
{
    public function store(Request $request, WorkLog $workLog)
    {
        // validate the incoming file
        if (!$request->hasFile('document-upload')) {
            return response()->json(['error' => 'There is no document present.'], 400);
        }

        $request->validate([
            'document-upload' => 'required|file|mimetypes:
                application/x-7z-compressed, application/vnd.rar,application/vnd.ms-excel,
                application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,
                application/vnd.openxmlformats-officedocument.presentationml.presentation,
                application/vnd.ms-powerpoint, application/pdf, application/msword,
                application/vnd.openxmlformats-officedocument.wordprocessingml.document,
            '
        ]);

        $pathFolder = public_path("work-logs/{$workLog->id}/uploads/documents");

        if(!File::isDirectory($pathFolder)){
            File::makeDirectory($pathFolder, 0777, true, true);
            // retry storing the file in newly created path.
        }

        // save the file in storage
        $path = $request->file('document-upload')->store("public/work-logs/{$workLog->id}/uploads/documents/");

        if (!$path) {
            return response()->json(['error' => 'The file could not be saved.']);
        }

        $uploadedFile = $request->file('document-upload');
        $document = null;

        DB::transaction(function () use ($uploadedFile, $document, $workLog) {
            // create document model
            $document = Document::create([
                'name' => $uploadedFile->hasName(),
                'extension' => $uploadedFile->extension(),
                'size' => $uploadedFile->getSize()
            ]);

            $workLog->documents()->save($document);
        });

        // return that image model back to the frontend
        return $document;
    }

    public function destroy(Request $request, WorkLog $workLog)
    {

    }
}
