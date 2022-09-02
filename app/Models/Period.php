<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
   @property bigint $timetable_id timetable id
@property bigint $timing_id timing id
@property bigint $class_subject_teacher_id class subject teacher id
@property bigint $venue_id venue id
@property int $day day
@property timestamp $created_at created at
@property timestamp $updated_at updated at
@property ClassSubjectTeacher $classSubjectTeacher belongsTo
@property Timing $timing belongsTo
@property Timetable $timetable belongsTo

 */
class Period extends Model
{

    /**
    * Database table name
    */
    protected $table = 'periods';

    /**
    * Mass assignable columns
    */
    protected $fillable=['timetable_id',
'timing_id',
'class_subject_teacher_id',
'venue_id',
'day'];

    /**
    * Date time columns.
    */
    protected $dates=[];

    /**
    * classSubjectTeacher
    *
    * @return BelongsTo
    */
    public function classSubjectTeacher()
    {
        return $this->belongsTo(KlassSubjectTeacher::class,'class_subject_teacher_id');
    }

    /**
    * timing
    *
    * @return BelongsTo
    */
    public function timing()
    {
        return $this->belongsTo(Timing::class,'timing_id');
    }

    /**
    * timetable
    *
    * @return BelongsTo
    */
    public function timetable()
    {
        return $this->belongsTo(Timetable::class,'timetable_id');
    }




}
