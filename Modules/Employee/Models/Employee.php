<?php

namespace Modules\Employee\Models;

use Carbon\Carbon;
use DateTime;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
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
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'created_at',
        'updated_at'
    ];


    /**
     * The hidden attributes.
     *
     * @var array
     */
    protected $hidden = [
        'excel_sheet_id',
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
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
        'county',
        'city',
        'zip',
        'region',
        'excel_sheet_id',
    ];


    /**
     * @return Attribute
     */
    public function middleInitial(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Str::upper($value),
        );
    }


    /**
     * @return Attribute
     */
    public function dateOfBirth(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('d/m/Y'),
            set: fn (string $value) => Carbon::parse($value)->format('Y-m-d'),
        );
    }


    /**
     * @return Attribute
     */
    public function dateOfJoining(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('d/m/Y'),
            set: fn (string $value) => Carbon::parse($value)->format('Y-m-d'),
        );
    }


    /**
     * @return Attribute
     */
    public function timeOfBirth(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('h:i:s A'),
            set: fn (string $value) => Carbon::parse($value)->format('H:i:s'),
        );
    }


   /**
     * @return Attribute
     */
    public function ageInYears(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => number_format((float) $value,'2','.',''),
        );
    }


   /**
     * @return Attribute
     */
    public function ageInCompany(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => number_format((float) $value,'2','.',''),
        );
    }


    /**
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d/m/Y h:i:s A');
    }


    /**
     * @return BelongsTo
     */
    public function excelSheet(): BelongsTo
    {
        return $this->belongsTo(ExcelSheet::class);
    }
}
