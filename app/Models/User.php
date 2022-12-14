<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
   @property varchar $username username
@property varchar $password password
@property text $remember_token remember token
@property datetime $created_at created at
@property datetime $updated_at updated at
@property \Illuminate\Database\Eloquent\Collection $teacher hasMany

 */
class User extends Model
{

    /**
    * Database table name
    */
    protected $table = 'users';

    /**
    * Mass assignable columns
    */
    protected $fillable=['username'];

    /**
    * Date time columns.
    */
    protected $dates=[];

    /**
    * teachers
    *
    * @return HasMany
    */
    public function teachers()
    {
        return $this->hasMany(Teacher::class,'user_id');
    }



}
