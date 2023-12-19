<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Helpers\UserRoleCodes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    // Easier to reach things

    /*
    1 - Admin
    2 - Evaluator / Penilai 1
    3 - Evaluator / Penilai 2
    4 - Staff / WargaKerja
    */

    public function isAdmin(): bool {          return $this->role == UserRoleCodes::ADMIN; }
    public function isEvaluator1(): bool {  return $this->role == UserRoleCodes::EVALUATOR_1; }
    public function isEvaluator2(): bool {  return $this->role == UserRoleCodes::EVALUATOR_2; }
    public function isAnEvaluator(): bool {  return $this->role == UserRoleCodes::EVALUATOR_1 || $this->role == UserRoleCodes::EVALUATOR_2; }
    public function isStaff(): bool {       return $this->role == UserRoleCodes::STAFF; }

    /**
     * Get the post's image.
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function worklogs(): HasMany
    {
        return $this->hasMany(WorkLog::class, 'author_id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(StaffUnit::class, 'staff_unit_id');
    }

    public function getRating(): int
    {
        return $this->workLogs()->count();
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function reject(): MorphOne {
        return $this->morphOne(SubmissionReject::class, 'rejectable');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'authentication',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

}
