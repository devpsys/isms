<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
   @property varchar $title title
@property datetime $created_at created at
@property datetime $updated_at updated at
@property \Illuminate\Database\Eloquent\Collection $classSubjectTeacher hasMany
@property \Illuminate\Database\Eloquent\Collection $timetable hasMany

 */
class Section extends Model
{

    /**
    * Database table name
    */
    protected $table = 'sections';

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
        return $this->hasMany(KlassSubjectTeacher::class,'session_id');
    }
    /**
    * timetables
    *
    * @return HasMany
    */
    public function timetables()
    {
        return $this->hasMany(Timetable::class,'section_id');
    }



}
