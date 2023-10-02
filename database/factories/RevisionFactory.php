<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Revision>
 */
class RevisionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = mt_rand(0, 4);

        $started_at = null;
        $expected_at = null;
        $submitted_at = null;

        switch ($status) {
            case 0:case 1:case 2:
                $started_at     = now()->subHours(4);
                $expected_at    = now()->subHours(4)->addHours(mt_rand(1,10));
                $submitted_at   = null;
                break;
            case 3:case 4:
                $started_at     = now()->subHours(3);
                $expected_at    = now()->subHours(3)->addHours(2,40);
                $submitted_at   = now()->subHours(3)->addHours(4,50);
                break;
        }

        return [
            'title' => fake()->jobTitle(),
            'body' => fake()->realText(50),

            'started_at' => $started_at,
            'expected_at' => $expected_at,
            'submitted_at' => $submitted_at,
        ];
    }
}
