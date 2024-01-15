<?php

use App\Helpers\WorkLogHelper;
use App\Models\Reject;
use App\Models\StaffSection;
use App\Models\SubmissionReject;
use App\Models\User;
use App\Models\WorkScope;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_logs', function (Blueprint $table) {
            $table->id();

            $table->string('description')->default('')->nullable();

            // status
            $table->integer('status')->default(WorkLogHelper::ONGOING);
            $table->decimal('rating', 2, 1)->nullable();

            $table->boolean('has_archived')->default(false);

            $table->date('started_at')->nullable();
            $table->date('expected_at')->nullable();
            // Submission date comes from the latest submission
            // isLatestSubmissionEvaluated

            //// Related tables:
            // Revisions
            // Images

            $table->foreignIdFor(User::class, 'author_id');
            $table->foreignIdFor(StaffSection::class)->nullable(); // Fallback field
            $table->foreignIdFor(WorkScope::class)->nullable(); // Main field
            $table->string('custom_workscope_title')->nullable(); // Alternative field

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_logs');
    }
};
