<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property bigint $section_id section id
 * @property varchar $title title
 * @property datetime $created_at created at
 * @property datetime $updated_at updated at
 * @property Collection $klassSubjectTeacher hasMany
 */
class Klass extends Model
{

    /**
     * Database table name
     */
    protected $table = 'klasses';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['section_id', 'title'];

    /**
     * Date time columns.
     */
    protected $dates = [];

    /**
     * klassSubjectTeachers
     *
     * @return HasMany
     */
    public function klassSubjectTeachers()
    {
        return $this->hasMany(KlassSubjectTeacher::class, 'class_id');
    }


}
