<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
   @property bigint $class_id class id
@property bigint $subject_id subject id
@property bigint $teacher_id teacher id
@property bigint $session_id session id
@property datetime $created_at created at
@property datetime $updated_at updated at
@property Session $section belongsTo
@property Teacher $teacher belongsTo
@property Subject $subject belongsTo
@property Class $klass belongsTo
@property \Illuminate\Database\Eloquent\Collection $period hasMany

 */
class KlassSubjectTeacher extends Model
{

    /**
    * Database table name
    */
    protected $table = 'klass_subject_teachers';

    /**
    * Mass assignable columns
    */
    protected $fillable=['class_id',
'subject_id',
'teacher_id',
'session_id'];

    /**
    * Date time columns.
    */
    protected $dates=[];

    /**
    * session
    *
    * @return BelongsTo
    */
    public function session()
    {
        return $this->belongsTo(Section::class,'session_id');
    }

    /**
    * teacher
    *
    * @return BelongsTo
    */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class,'teacher_id');
    }

    /**
    * subject
    *
    * @return BelongsTo
    */
    public function subject()
    {
        return $this->belongsTo(Subject::class,'subject_id');
    }

    /**
    * class
    *
    * @return BelongsTo
    */
    public function class()
    {
        return $this->belongsTo(Klass::class,'class_id');
    }

    /**
    * periods
    *
    * @return HasMany
    */
    public function periods()
    {
        return $this->hasMany(Period::class,'class_subject_teacher_id');
    }



}
