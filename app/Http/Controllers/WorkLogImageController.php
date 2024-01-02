<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\WorkLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class WorkLogImageController extends Controller
{
    private $image;
    private array $uploadedImage;

    function __construct() {
        $this->uploadedImage = [
            'name' => '',
            'extension' => '',
            'size' => 0
        ];
    }

    public function store(Request $request, WorkLog $workLog)
    {
        // return response($workLog, 200);
        info('uploading image in controller for worklog with id of '.$workLog->id);

        // validate the incoming file
        if (!$request->hasFile('image-upload')) {
            return response()->json(['error' => 'There is no image present.'], 400);
        }
        // return response('', 200);
        // info($request->all());

        $validated = $request->validate([
            'image-upload' => 'required|file|image|mimetypes:image/*'
        ]);

        info($validated);
        info('Ext b4 = ' . $request->file('image-upload')->getExtension());

        // $localDriverPathFolder = "public/work-logs/{$workLog->id}/images";

        Storage::makeDirectory("public\work-logs\\{$workLog->id}\images");
        // good
        // $yourModel
        // ->addMedia($pathToFile)
        // ->toMediaCollection();
        $uploadedImage['name'] = $request->file('image-upload')->hashName();
        $uploadedImage['extension'] = $request->file('image-upload')->extension();
        $uploadedImage['size'] = $request->file('image-upload')->getSize();

        info('Image info ' . json_encode($uploadedImage));


        // save the file in storage
        $path = $request->file('image-upload')->store("public\work-logs\\{$workLog->id}\images");

        // info('Ext after = ' . $request->file('image-upload')->extension());

        // info('Path is at ' . $path);

        if (!$path) {
            return response()->json(['error' => 'The file could not be saved.'], 400);
        }

        // info('Made it through error');

        DB::transaction(function () use ($workLog, $request) {
            $this->image = Image::create([
                'name' => $request->file('image-upload')->hashName(),
                'extension' => $request->file('image-upload')->extension(),
                'path' => "work-logs\\{$workLog->id}\images\\{$request->file('image-upload')->hashName()}",
                'size' => $request->file('image-upload')->getSize(),
                'imageable_type' => 'App\Models\WorkLog',
                'imageable_id' => $workLog->id,
            ]);
        });
        info('Image created ' . $this->image);

        // return that image model back to the frontend
        return $this->image;
    }
}
