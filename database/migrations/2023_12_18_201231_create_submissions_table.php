<?php

use App\Models\User;
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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            // Related data: documents, worklogs
            $table->foreignIdFor(WorkLog::class, 'work_log_id');
            $table->tinyInteger('number');
            $table->boolean('isAccept')->default(false);
            $table->text('body')->nullable();

            $table->foreignIdFor(User::class, 'evaluator_id')->nullable();
            $table->text('evaluator_comment')->nullable();
            $table->timestamp('evaluated_at')->nullable();

            $table->unique(['work_log_id', 'number'],'wl_count_index');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
