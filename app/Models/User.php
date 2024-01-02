<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Helpers\UserRoleCodes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\Conversions\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, InteractsWithMedia;

    // Easier to reach things

    /*
    1 - Admin
    2 - Evaluator / Penilai 1
    3 - Evaluator / Penilai 2
    4 - Staff / WargaKerja
    */

    public function isAdmin():          bool {  return session('selected_role_id') == UserRoleCodes::ADMIN; }
    public function isEvaluator1():     bool {  return session('selected_role_id') == UserRoleCodes::EVALUATOR_1; }
    public function isEvaluator2():     bool {  return session('selected_role_id') == UserRoleCodes::EVALUATOR_2; }
    public function isAnEvaluator():    bool {  return session('selected_role_id') == UserRoleCodes::EVALUATOR_1 || session('selected_role_id') == UserRoleCodes::EVALUATOR_2; }
    public function isStaff():          bool {  return session('selected_role_id') == UserRoleCodes::STAFF; }

    /**
     * Get the post's image.
     */
    public function avatar(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }

    public function rating(): int
    {
        return $this->workLogs()->count();
    }

    public function worklogs(): HasMany
    {
        return $this->hasMany(WorkLog::class, 'author_id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(StaffUnit::class, 'staff_unit_id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->using(RoleUser::class);
    }

    // public function evaluator1s(): BelongsToMany
    // {
    //     return $this->roles->wherePivot('role', UserRoleCodes::EVALUATOR_1);
    // }

    // public function evaluator2s(): BelongsToMany
    // {
    //     return $this->roles->wherePivot('role', UserRoleCodes::EVALUATOR_2);
    // }

    public function evaluator1(): BelongsTo {
        return $this->belongsTo(User::class, 'evaluator1_id', 'id');
    }

    public function evaluator2(): BelongsTo {
        return $this->belongsTo(User::class, 'evaluator2_id', 'id');
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

    protected static function booted(): void
    {
        static::saved(function (User $user) {
            if ($user->evaluator1()->is($user) || $user->evaluator2()->is($user)) {
                Log::notice('Trying to set evaluator as it\'s own. Forbidden!' . $user->id );
            }
        });
    }
}
