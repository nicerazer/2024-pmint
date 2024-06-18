<?php

use App\Helpers\WorkLogHelper;
use App\Models\Reject;
use App\Models\StaffSection;
use App\Models\StaffUnit;
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
            // $table->decimal('rating', 2, 1)->nullable();

            $table->boolean('has_archived')->default(false);

            $table->date('started_at');
            $table->date('expected_at');
            // Submission date comes from the latest submission
            // isLatestSubmissionEvaluated

            //// Related tables:
            // Revisions
            // Images

            $table->foreignIdFor(User::class, 'author_id')->cascadeOnDelete();;
            // $table->boolean('is_main')->default(false);

            // wrkscp_is_main : form
            // wrkscp_main_id : form
            // wrkscp_alt_section_id : auth()->user()->section->id
            // wrkscp_alt_title : ? form
            $table->boolean('wrkscp_is_main')->default(true);
            $table->foreignIdFor(WorkScope::class, 'wrkscp_main_id')->cascadeOnDelete();;
            $table->foreignIdFor(StaffUnit::class, 'wrkscp_alt_unit_id')->cascadeOnDelete();;
            $table->string('wrkscp_alt_title')->nullable();

            // $table->foreignIdFor(StaffSection::class)->nullable(); // Fallback field
            // $table->foreignIdFor(WorkScope::class)->nullable(); // Main field
            // $table->string('custom_workscope_title')->nullable(); // Alternative field

            $table->timestamps();
            // $table->softDeletes();
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
