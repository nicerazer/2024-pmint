<?php

namespace Database\Factories;

use App\Models\Submission;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Submission>
 */
class SubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'body' => fake()->realTextBetween(10, 30),
        ];
    }

    public function rejected(): Factory {
       return $this->state(function (array $attributes) {
            return [
                'evaluator_comment' => 'Kerja ada problem sikit. Kena baiki ya',
                'evaluated_at' => now(),
            ];
       })->afterMaking(function (Submission $submission) {
            $submission->evaluator_id = $submission->worklog->author->evaluator1_id;
       });
    }

    public function accepted(): Factory {
       return $this->state(function (array $attributes) {
            return [
                'evaluator_comment' => fake()->realTextBetween(10, 30),
                'evaluated_at' => now(),
            ];
       })->afterMaking(function (Submission $submission) {
            $submission->evaluator_id = $submission->worklog->author->evaluator1_id;
       });
    }

    public function configure(): static
    {
       return $this->afterCreating(function (Submission $submission) {
            $sampleImages = collect([
                'photo-1550258987-190a2d41a8ba.jpg', 'photo-1559181567-c3190ca9959b.jpg',
                'photo-1559703248-dcaaec9fab78.jpg', 'photo-1494253109108-2e30c049369b.jpg',
                // 'photo-1565098772267-60af42b81ef2.jpg', 'photo-1572635148818-ef6fd45eb394.jpg',
                // 'photo-1601004890684-d8cbf643f5f2.jpg',
            ]);
            $seedImageCount = 3;

            foreach ($sampleImages as $sampleImage) {
                $name = $this->faker->word();
                $file = new UploadedFile(database_path('seeders/stubs/' . $sampleImage), $name, 'image/jpeg', null, true);

                $submission->addMedia($file)
                    ->preservingOriginal()
                    ->usingName($name)
                    ->usingFileName($name.'.jpg')
                    ->toMediaCollection('images');
            }
        });
    }


}
