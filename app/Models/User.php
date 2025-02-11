<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $patronymic
 * @property string $email
 * @property string $password
 * @property string $birth_date
 * @property-read string $full_name
 *
 */

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'patronymic',
        'email',
        'password',
        'birth_date'
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

    /**
     * @return Attribute
     */
    public function fullName(): Attribute {
        return Attribute::get(fn () => $this->last_name . " " . $this->first_name . " " . $this->patronymic);
    }

    public function firstFullName(): Attribute {
        return Attribute::get(fn () => $this->first_name . " " . $this->patronymic . " " . $this->last_name);
    }

    /**
     * @return HasMany
     */
    public function lunarMissions(): HasMany
    {
        return $this->hasMany(LunarMission::class);
    }

    public function spaceFlights(): HasMany
    {
        return $this->hasMany(SpaceFlights::class);
    }

}
