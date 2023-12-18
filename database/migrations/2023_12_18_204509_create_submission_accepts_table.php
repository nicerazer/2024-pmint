<?php

use App\Models\User;
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
        Schema::create('submission_accepts', function (Blueprint $table) {
            $table->id();

            // Body is from evaluator 1 only
            $table->string('body')->nullable();
            $table->morphs('submission_acceptable');

            $table->timestamp('evaluator_1_accepted_at')->nullable();
            $table->foreignIdFor(User::class(), 'evaluator_1_id')->nullable();
            $table->timestamp('level_2_accepted_at')->nullable();
            $table->foreignIdFor(User::class(), 'evaluator_1_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_log_accepts');
    }
};
