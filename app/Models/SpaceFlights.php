<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SpaceFlights extends Model
{
    protected $fillable = [
        'flight_number',
        'destination',
        'launch_date',
        'seats_available',
    ];

    public function user():HasOne {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function books():HasMany {
        return $this->hasMany(UserFlight::class, 'flight_id', 'id');
    }
}
