<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property array $launch_details
 * @property array $landing_details
 * @property array $spacecraft
 *
 */
class LunarMission extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'name',
        'launch_details',
        'landing_details',
        'spacecraft',
    ];
    /**
     * @var string[]
     */
    protected $casts = [
        'launch_details' => 'json',
        'landing_details' => 'json',
        'spacecraft' => 'json',
    ];

    public function author():HasOne {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
