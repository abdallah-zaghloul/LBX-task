<?php

namespace Modules\Employee\Models;

use Carbon\Carbon;
use DateTime;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Employee.
 *
 * @package namespace App\Models;
 */
class Employee extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * @var string
     */
    protected $table = 'employees';

    /**
     * @var bool
     */
    public $timestamps = true;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name',
        'name_prefix',
        'first_name',
        'middle_initial',
        'last_name',
        'gender',
        'email',
        'date_of_birth',
        'time_of_birth',
        'age_in_years',
        'date_of_joining',
        'age_in_company',
        'phone_no',
        'place_name',
        'country',
        'city',
        'zip',
        'region',
    ];

    /**
     * @param $dateOfBirth
     * @return string
     */
    public function getDateOfBirthAttribute($dateOfBirth): string
    {
        return Carbon::parse($dateOfBirth)->format('d/m/Y');
    }

    /**
     * @param $dateOfJoining
     * @return string
     */
    public function getDateOfJoiningAttribute($dateOfJoining): string
    {
        return Carbon::parse($dateOfJoining)->format('d/m/Y');
    }

    /**
     * @param $timeOfBirth
     * @return string
     */
    public function getTimeOfBirthAttribute($timeOfBirth): string
    {
        return Carbon::parse($timeOfBirth)->format('h:i:s A');
    }

    /**
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d/m/Y h:i:s A');
    }
}
