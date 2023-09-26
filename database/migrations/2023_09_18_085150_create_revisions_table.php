<?php

use App\Models\Worklog;
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

            $table->foreignIdFor(Worklog::class);

            $table->string('title');
            $table->string('body');

            $table->dateTime('started_at');
            $table->dateTime('expected_at');
            $table->dateTime('submitted_at')->nullable();

            $table->dateTime('seen_at')->nullable;

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
