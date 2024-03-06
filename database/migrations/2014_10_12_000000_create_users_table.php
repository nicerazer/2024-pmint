<?php

use App\Models\StaffSection;
use App\Models\StaffUnit;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ic')->unique();
            $table->string('email')->unique();
            $table->foreignIdFor(StaffUnit::class);
            // $table->foreignIdFor(StaffUnit::class)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            // $table->foreignIdFor(User::class, 'evaluator1_id')->nullable();
            // $table->foreignIdFor(User::class, 'evaluator2_id')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
