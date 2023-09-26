<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

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

    /*
    0 - Admin
    1 - HR
    2 - Evaluator / Penilai 1
    3 - Evaluator / Penilai 2
    4 - Staff / WargaKerja
    */

    public function isAdmin(): bool { return $this->role        == 0; }
    public function isHR(): bool { return $this->role           == 1; }
    public function isEvaluator1(): bool { return $this->role   == 2; }
    public function isEvaluator2(): bool { return $this->role   == 3; }
    public function isStaff(): bool { return $this->role        == 4; }

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

}
