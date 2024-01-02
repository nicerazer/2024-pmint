<?php

namespace Database\Seeders;

use App\Models\Revision;
use App\Models\Subbb;
use App\Models\Submission;
use App\Models\User;
use App\Models\WorkLog;
use App\Models\WorkScope;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class WorkLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workScopes = WorkScope::all();

        $admin = User::where('name', 'admin')->first();
        $staff = User::where('name', 'staff')->first();

        $generations = [];
        $dateGenerate = now();
        // for($i = 0; $i < 10; ++$i) {
        //     array_push($generations, array('created_at' => $dateGenerate->subMonth(), 'updated_at' => $dateGenerate->subMonth()));
        // }
        $reject_count = 3;
        WorkLog::factory(3)->for($workScopes[0])->for($admin, 'author')
        ->has(Submission::factory(3)->rejected())
        ->has(Submission::factory()->accepted())
        // ->has($singleSubmissionWithAccept)
        ->create();

        // $singleSubmissionWithoutAccept = Submission::factory()->sequence(fn (Sequence $s) => ['number' => $s->index]);
        // $multipleSubmissionWithRejectsOnly = Submission::factory($reject_count)
        //     ->sequence(fn (Sequence $s) => ['number' => $s->index]);
        // $singleSubmissionWithAccept = Submission::factory()
        //     ->sequence(fn (Sequence $s) => ['number' => $s->index + $reject_count]);
        // Admin and Staff
        // WorkLog::factory()->count(5)->for($admin, 'author')->for($workScopes[0])
        // ->has(Submission::factory(), 'submissions')->create();
        // WorkLog::factory()->count(5)->for($admin, 'author')->for($workScopes[0])
        // ->has($singleSubmissionWithoutAccept)->create();
        // WorkLog::factory()->count(1)->for($admin, 'author')->for($workScopes[0])
        // ->has($multipleSubmissionWithRejectsOnly)
        // ->has($singleSubmissionWithAccept)
        // ->create();
        // WorkLog::factory()->count(5)->for($admin, 'author')->for($workScopes[0])->hasReject()->has(Revision::factory()->count(2)->hasReject())->hasImages(2)->create();
        // WorkLog::factory()->count(5)
        // ->sequence(['started_at' => $dateGenerate->subMonths(3), 'updated_at' =>
        // $dateGenerate])
        // ->for($staff, 'author')->for($workScopes[0])->hasReject()->hasRevisions(2)->hasImages(2)->create();

        // foreach($workScopes as $workScope) {
        //     $user = User::inRandomOrder()->first();
        //     WorkLog::factory()->count(10)->for($user, 'author')->for($workScope)->hasRevisions(2)->hasImages(3)->create();
        //     WorkLog::factory()->count(10)->for($user, 'author')->for($workScope)->hasImages(3)->create();
        //     WorkLog::factory()->count(10)->for($user, 'author')->for($workScope)->create();
        // }

    }
}
