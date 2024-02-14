<?php

namespace App\Http\Controllers;

use App\Jobs\TemporaryFileCleanup;
use App\Models\TemporaryUpload;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Flysystem\UnableToCheckFileExistence;

class TemporaryUploadController extends Controller
{
    // Send a cronjob to destroy this temporary file using a set time.
    // Information are kept in the database

    public function process(Request $request): string {
        // We don't know the name of the file input, so we need to grab
        // all the files from the request and grab the first file.
        /** @var UploadedFile[] $files */
        $files = $request->allFiles();

        Log::info("Temporary Upload: Initiaiting");

        if (empty($files)) {
            abort(422, 'No files were uploaded.');
        }

        if (count($files) > 1) {
            abort(422, 'Only 1 file can be uploaded at a time.');
        }

        Log::info("Temporary Upload: Files are available...");

        // Now that we know there's only one key, we can grab it to get
        // the file from the request.
        $requestKey = array_key_first($files);

        // If we are allowing multiple files to be uploaded, the field in the
        // request will be an array with a single file rather than just a
        // single file (e.g. - `csv[]` rather than `csv`). So we need to
        // grab the first file from the array. Otherwise, we can assume
        // the uploaded file is for a single file input and we can
        // grab it directly from the request.
        $file = is_array($request->input($requestKey))
            ? $request->file($requestKey)[0]
            : $request->file($requestKey);

        Log::info("Temporary Upload: Storing...");

        // Store the file in a temporary location and return the location
        // for FilePond to use.
        return $file->store(
            path: 'tmp/'.now()->timestamp.'-'.Str::random(20)
        );
    }

    public function revert(Request $request): void {
        // Log::info($request->getContent());
        // Log::info(Storage::missing($request->getContent()));
        if (Storage::missing($request->getContent()))
            throw new UnableToCheckFileExistence("Unable to revert upload, file is missing. System will still continue clean up so don't worry.");
        Storage::delete($request->getContent());
    }

    public function restore(Request $request) {
        Log::info('Inprogress');
        // Check how to retrieve the id
        dd($request);
        $request->input('id');
        die();

        $temporaryUpload = TemporaryUpload::findOrFail($request->query('id'));
        // Uses the id to fetch data
        // Review!!!
        // Ask laravel if this need review!
        // Access-Control-Expose-Headers: Content-Disposition
        return response()->file(Storage::path('temporary-uploads/'.$temporaryUpload->file_name),
            [ 'Content-Disposition' => "inline; filename=\"{$temporaryUpload->file_name}\"" ]
        );
    }
}
