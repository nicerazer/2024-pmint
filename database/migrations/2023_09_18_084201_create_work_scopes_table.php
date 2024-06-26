<?php

use App\Models\StaffUnit;
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
        Schema::create('work_scopes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignIdFor(StaffUnit::class)->cascadeOnDelete();;
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_scopes');
    }
};
