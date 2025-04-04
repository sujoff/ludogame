<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasApiTokens;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'external_id',
        'settings',
        'statistics',
        'profile_image',
        'firebase_id',
        'skin_settings',
        'coins',
        'gems',
        'age',
        'gender',
        'xp',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'settings' => 'array',
            'statistics' => 'array',
            'skin_settings' => 'array',
            'coins' => 'float',
            'gems' => 'float',
            'xp' => 'integer',
        ];
    }

    public function providers()
    {
        return $this->hasMany(Provider::class,'user_id','id');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function allFriends(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(self::class, 'friends', 'user_id', 'friend_id');
    }

    public function blockedFriends(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->allFriends()->wherePivot('blocked', true);
    }

    public function friends(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->allFriends()->wherePivot('blocked', false);
    }

    public function friendRequests(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(self::class, 'friend_requests', 'friend_id', 'user_id');
    }

    public function routeNotificationForFcm()
    {
        return $this->firebase_id;
    }
}
