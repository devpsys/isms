<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property bigint $session_id session id
 * @property bigint $section_id section id
 * @property varchar $term term
 * @property datetime $published published
 * @property text $config config
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 * @property Section $section belongsTo
 * @property Session $session belongsTo
 * @property Collection $period hasMany
 */
class Timetable extends Model
{

    /**
     * Database table name
     */
    protected $table = 'timetables';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['session_id',
        'section_id',
        'term',
        'published',
        'config'];

    /**
     * Date time columns.
     */
    protected $dates = ['published'];

    /**
     * section
     *
     * @return BelongsTo
     */
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    /**
     * session
     *
     * @return BelongsTo
     */
    public function session()
    {
        return $this->belongsTo(Session::class, 'session_id');
    }

    /**
     * periods
     *
     * @return HasMany
     */
    public function periods()
    {
        return $this->hasMany(Period::class, 'timetable_id');
    }


}
