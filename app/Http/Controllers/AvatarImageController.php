<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvatarImageController extends Controller
{
    public function store(Request $request) {
        // return response($workLog, 200);

        // validate the incoming file
        if (!$request->hasFile('image-upload')) {
            return response()->json(['error' => 'There is no image present.'], 400);
        }
        // return response('', 200);
        // info($request->all());

        $validated = $request->validate([
            'image-upload' => 'required|file|image|mimetypes:image/*'
        ]);

        // $path = $request->file('image-upload')->store("public\work-logs\\{$workLog->id}\images");
        Auth::user()
        ->addMedia($validated['image-upload'])
        ->toMediaCollection();

        // Check for? Uploads?
    }

    public function destroy() {

    }
}
