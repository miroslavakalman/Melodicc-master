<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Track;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
protected $fillable = [
    'name',
    'email',
    'password',
    'avatar_path',
    'bio',
];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
        ];
    }
    public function roles()
{
    return $this->belongsToMany(Role::class);
}

// хелпер для проверки роли
public function hasRole(string $roleName): bool
{
    return $this->roles()->where('name', $roleName)->exists();
}

// хелпер для назначения роли
public function assignRole(string $roleName): void
{
    $role = Role::where('name', $roleName)->first();
    if ($role && ! $this->hasRole($roleName)) {
        $this->roles()->attach($role);
    }
}
public function albums()
{
    return $this->hasMany(Album::class, 'artist_id');
}

/**
 * Треки, которые загрузил пользователь.
 */
public function tracks()
{
    return $this->hasMany(Track::class, 'artist_id');
}

/**
 * Лайки пользователя на треки.
 */
public function likes()
{
    return $this->hasMany(Like::class);
}
/**
 * Лайкнутые треки пользователя.
 */
public function favorites(): BelongsToMany
{
    return $this->belongsToMany(Track::class);
}
// В User.php добавим:
public function ban(string $reason): void
{
    $this->update([
        'banned_at' => now(),
        'ban_reason' => $reason
    ]);
}

public function unban(): void
{
    $this->update([
        'banned_at' => null,
        'ban_reason' => null
    ]);
}

public function isBanned(): bool
{
    return !is_null($this->banned_at);
}
}
