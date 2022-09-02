<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property bigint $user_id user id
 * @property varchar $staff_number staff number
 * @property enum $title title
 * @property varchar $fullname fullname
 * @property varchar $gsm gsm
 * @property text $address address
 * @property datetime $created_at created at
 * @property datetime $updated_at updated at
 * @property User $user belongsTo
 * @property Collection $classSubjectTeacher hasMany
 */
class Teacher extends Model
{
    const TITLE_MALAM = 'Malam';

    const TITLE_MALAMA = 'Malama';

    const TITLE_USTAZ = 'Ustaz';

    const TITLE_USTAZIYYA = 'Ustaziyya';

    const TITLE_SHEIKH = 'Sheikh';

    /**
     * Database table name
     */
    protected $table = 'teachers';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['user_id',
        'staff_number',
        'title',
        'fullname',
        'gsm',
        'address'];

    /**
     * Date time columns.
     */
    protected $dates = [];

    /**
     * user
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * classSubjectTeachers
     *
     * @return HasMany
     */
    public function classSubjectTeachers()
    {
        return $this->hasMany(KlassSubjectTeacher::class, 'teacher_id');
    }


}
