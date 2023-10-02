<?php

use App\Helpers\WorkLogHelper;
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

            $table->dateTime('started_at')->nullable();
            $table->dateTime('expected_at')->nullable();
            $table->dateTime('submitted_at')->nullable();

            $table->timestamp('level_1_accepted_at')->nullable();
            $table->timestamp('level_2_accepted_at')->nullable();

            // Related tables:
            // Revisions
            // Images
            $table->foreignIdFor(User::class, 'author_id');
            $table->foreignIdFor(WorkScope::class);

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
