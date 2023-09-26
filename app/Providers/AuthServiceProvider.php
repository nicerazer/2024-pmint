<?php

namespace App\Providers;

use App\Models\User;
use App\Models\WorkLog;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Wargakerja - Add worklog.
        // Wargakerja - Update worklog set status (SUBMITTED), completed_at
        // Wargakerja - (Soft) Delete
        // Penilai 1 - Update worklog evaluate: rating, accepted_at
        // Penilai 1 - Update worklog evaluate: rating, accepted_at
        // Wargakerja - Update worklog set completed

        Gate::define('worklog-add', function(User $user) {
            return $user->isStaff();
        });

        Gate::define('worklog-update-basic', function(User $user, WorkLog $worklog) {
            return $user->isStaff() &&
            $worklog->started_at != null && $worklog->expected_at != null &&
            // -----
            $worklog->submitted_at == null &&
            $worklog->accepted_level_1_at == null &&
            $worklog->accepted_level_2_at == null;
        });

        Gate::define('worklog-submission', function(User $user, WorkLog $worklog) {
            return $user->isStaff() &&
            $worklog->started_at != null && $worklog->expected_at != null &&
            // -----
            $worklog->submitted_at == null &&
            $worklog->accepted_level_1_at == null &&
            $worklog->accepted_level_2_at == null;
        });

        Gate::define('worklog-evaluator-1-evaluate-reject', function(User $user, WorkLog $worklog) {
            return $user->isEvaluator1() &&

            $worklog->started_at != null && $worklog->expected_at != null && $worklog->submitted_at != null &&
            // -----
            $worklog->accepted_level_1_at == null &&
            $worklog->accepted_level_2_at == null;
        });

        Gate::define('worklog-evaluator-2-evaluate-reject', function(User $user, WorkLog $worklog) {
            return $user->isEvaluator2() &&

            $worklog->started_at != null && $worklog->expected_at != null && $worklog->submitted_at != null && $worklog->accepted_level_1_at != null &&
            // -----
            $worklog->accepted_level_2_at == null;
        });
    }
}
