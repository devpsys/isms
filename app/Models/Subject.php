<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
   @property varchar $title title
@property datetime $created_at created at
@property datetime $updated_at updated at
@property \Illuminate\Database\Eloquent\Collection $classSubjectTeacher hasMany

 */
class Subject extends Model
{

    /**
    * Database table name
    */
    protected $table = 'subjects';

    /**
    * Mass assignable columns
    */
    protected $fillable=['title'];

    /**
    * Date time columns.
    */
    protected $dates=[];

    /**
    * classSubjectTeachers
    *
    * @return HasMany
    */
    public function classSubjectTeachers()
    {
        return $this->hasMany(KlassSubjectTeacher::class,'subject_id');
    }


    public function instructors()
    {
        return [];
    }


}
