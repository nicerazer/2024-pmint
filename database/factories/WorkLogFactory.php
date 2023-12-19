<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkLog>
 */
class WorkLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $level_1_at = mt_rand(0,1) == 1 ? now() : null;
        // $level_2_at = mt_rand(0,1) == 1 && $level_1_at ? now()->addHours(mt_rand(0,50)) : null;

        // Status

        // ONGOING   0
        // SUBMITTED 1
        // TOREVISE  2
        // COMPLETED 3
        // REJECTED  4
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
            // 'level_1_accepted_at' => $level_1_at,
            // 'level_2_accepted_at' => $level_2_at,

            'rating' => round(mt_rand(0, 50) / 10 * 2 ) / 2,

            'status' => $status,

            'description' => fake()->realText($maxNbChars = 100, $indexSize = 2),

            'submitted_at' => now(),
            'submitted_body' => fake()->realText($maxNbChars = 100, $indexSize = 2),

            'started_at' => $started_at,
            'expected_at' => $expected_at,
            'submitted_at' => $submitted_at,
        ];
    }
}
