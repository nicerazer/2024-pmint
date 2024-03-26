<?php

namespace Database\Factories;

use App\Helpers\WorkLogCodes;
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
        // Status

        // ONGOING   0
        // SUBMITTED 1
        // TOREVISE  2
        // COMPLETED 3
        // REJECTED  4
        $status = mt_rand(0, 4);

        $started_at = null;
        $expected_at = null;

        switch ($status) {
            case WorkLogCodes::ONGOING: case WorkLogCodes::SUBMITTED: case WorkLogCodes::TOREVISE:
                $started_at     = now()->subDays(4);
                $expected_at    = now()->addDays(3)->addDays(mt_rand(1,10));
                // $submitted_at   = null;
                break;
            case 3:case 4:
                $started_at     = now()->subDays(12);
                $expected_at    = now()->subDays(10)->addDays(1,10);
                // $submitted_at   = now()->subDays(3)->addDays(4,50);
                break;
        }

        $luck_main_or_alt = mt_rand(1,2);

        return [
            'status' => $status,

            'description' => fake()->realText($maxNbChars = 100, $indexSize = 2),

            'wrkscp_is_main' => $luck_main_or_alt == 1, // Should work
            'wrkscp_main_id' => mt_rand(1,12), // Should work
            'wrkscp_alt_unit_id' => mt_rand(1,5), // Should work
            'wrkscp_alt_title' => $luck_main_or_alt == 1 ? NULL : fake()->realText($maxNbChars = 10, $indexSize = 2),

            'started_at' => $started_at,
            'expected_at' => $expected_at,
        ];
    }

    public function workScopeAlt(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'wrkscp_is_main' => false,
                'wrkscp_main_id' => mt_rand(1),
                'wrkscp_alt_unit_id' => mt_rand(1,2),
                'wrkscp_alt_title' => fake()->realText($maxNbChars = 10, $indexSize = 2),
            ];
        });
    }
}
