<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;

class ImageController extends Controller
{
    /**
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImageRequest $request)
    {
        // validate the incoming file
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'There is no file present.'], 400);
        }

        $request->validate([
            'image' => 'required|file|image|mimetypes:
                image/*,
                application/vnd.ms-excel,
                application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,
                application/x-7z-compressed,
                application/vnd.rar,
                application/vnd.openxmlformats-officedocument.presentationml.presentation,
                application/vnd.ms-powerpoint,
                application/pdf,
                application/vnd.openxmlformats-officedocument.wordprocessingml.document,
                application/msword
            '
        ]);

        // save the file in storage
        $path = $request->file('image')->store('public/images');

        if (!$path) {
            return response()->json(['error' => 'The file could not be saved.'], 500);
        }

        $uploadedFile = $request->file('image');

        // create image model
        $image = Image::create([
            'name' => $uploadedFile->hasName(),
            'extension' => $uploadedFile->extension(),
            'size' => $uploadedFile->getSize()
        ]);

        // return that image model back to the frontend
        return $image;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateImageRequest $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        //
    }
}
