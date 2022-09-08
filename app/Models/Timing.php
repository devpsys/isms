<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property time $time_from time from
 * @property time $time_to time to
 * @property datetime $created_at created at
 * @property datetime $updated_at updated at
 * @property Collection $period hasMany
 */
class Timing extends Model
{

    /**
     * Database table name
     */
    protected $table = 'timings';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['time_from', 'time_to'];

    /**
     * Date time columns.
     */
    protected $dates = [];

    /**
     * periods
     *
     * @return HasMany
     */
    public function periods()
    {
        return $this->hasMany(Period::class, 'timing_id');
    }


}
