<?php

use App\Models\WorkLog;
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
        Schema::create('revisions', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(WorkLog::class);
            // $table->string('title');
            $table->string('body');

            $table->date('started_at');
            $table->date('expected_at');
            $table->date('submitted_at')->nullable();

            // Relationships
            // Images, Reject Or Accept

            // $table->string('reject_title');
            // $table->string('reject_body');
            // $table->date('rejected_at');
            // $table->date('seen_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revisions');
    }
};
