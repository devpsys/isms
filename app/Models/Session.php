<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
   @property varchar $session session
@property datetime $created_at created at
@property datetime $updated_at updated at
@property \Illuminate\Database\Eloquent\Collection $timetable hasMany

 */
class Session extends Model
{

    /**
    * Database table name
    */
    protected $table = 'sessions';

    /**
    * Mass assignable columns
    */
    protected $fillable=['session'];

    /**
    * Date time columns.
    */
    protected $dates=[];

    /**
    * timetables
    *
    * @return HasMany
    */
    public function timetables()
    {
        return $this->hasMany(Timetable::class,'session_id');
    }



}
