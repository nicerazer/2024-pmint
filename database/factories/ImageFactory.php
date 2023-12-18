<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    private static $counter = 1;

    public function definition(): array
    {
        info('creating an image...');
        // $generated_image_url = fake()->image();

        // $image = fake()->image();
        // $imageFile = new File($image);
        $generated_name = self::$counter++.'-'.fake()->bothify('?????-#####');

        return [
            'name' => $generated_name,
            'extension' => '',
            'path' => "",
            'size' => 0,
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (Image $image) {
            // ...
        })->afterCreating(function (Image $image) {

            $sampleImages = collect([
                'seedfiles\sampleimages\photo-1550258987-190a2d41a8ba.jpg',
                'seedfiles\sampleimages\photo-1559181567-c3190ca9959b.jpg',
                'seedfiles\sampleimages\photo-1559703248-dcaaec9fab78.jpg',
                'seedfiles\sampleimages\photo-1494253109108-2e30c049369b.jpg',
                'seedfiles\sampleimages\photo-1565098772267-60af42b81ef2.jpg',
                'seedfiles\sampleimages\photo-1572635148818-ef6fd45eb394.jpg',
                'seedfiles\sampleimages\photo-1601004890684-d8cbf643f5f2.jpg',
            ]);

            $imagePath = 'work-logs-test\\'.$image->imageable->id.'\images\\';
            $imageName = $image->name. '-' .$image->size. '.jpg';

            // Storage::makeDirectory('public\\' . $imagePath);
            // Storage::makeDirectory('/somewhere');
            // $pathFolder = "public/work-logs/{$workLog->id}/images";
            // return response('', 200);

            // Storage::makeDirectory($pathFolder);
            $imageLocationReferencedHere = 'public\\' . $imagePath . $imageName;

            Storage::copy(
                $sampleImages->random(),
                $imageLocationReferencedHere
            );

            $image->path = $imagePath . $imageName;
            $image->size = Storage::size($imageLocationReferencedHere);
            $image->extension = Storage::mimeType($imageLocationReferencedHere);
            $image->save();
        });
    }
}
