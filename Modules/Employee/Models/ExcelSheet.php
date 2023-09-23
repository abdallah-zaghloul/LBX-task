<?php

namespace Modules\Employee\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use DateTime;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Employee\Enums\ExcelSheetStatusEnum;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ExcelSheet.
 *
 * @package namespace App\Models;
 */
class ExcelSheet extends Model implements Transformable
{
    use TransformableTrait,HasUuids;

    /**
     * @var string
     */
    protected $table = 'excel_sheets';


    /**
     * @var bool
     */
    public $incrementing = false;


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
     * The cast attributes.
     *
     * @var array
     */
    protected $casts = [
        'errors' => 'collection',
    ];


    /**
     * The hidden attributes.
     *
     * @var array
     */
    protected $hidden = [
        'path',
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'path',
        'status',
        'errors',
    ];


    /**
     * @var string[]
     */
    protected $appends = [
        'url',
        'updates_url'
    ];


    /**
     * @return Attribute
     */
    public function path(): Attribute
    {
        return Attribute::make(
            set: function (UploadedFile $file) {
               $file->storePubliclyAs("ExcelSheet", $name = "{$this->attributes['id']}.{$file->getClientOriginalExtension()}");
               return "ExcelSheet/$name";
            },
        );
    }


    /**
     * @return Attribute
     */
    public function url(): Attribute
    {
        return Attribute::make(
            get: fn () => @Storage::url($this->attributes['path'])
        );
    }


    /**
     * @return Attribute
     */
    public function updatesUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => route('excelSheet.show',['id' => $this->attributes['id']])
        );
    }


    /**
     * @return Attribute
     */
    public function status(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ExcelSheetStatusEnum::tryFrom($value),
            set: fn (ExcelSheetStatusEnum $excelSheetStatusEnum) => $excelSheetStatusEnum->value
        );
    }


    /**
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('d/m/Y h:i:s A');
    }


    /**
     * @return HasMany
     */
    public function employees(): HasMany
    {
        return $this->hasMany(ExcelSheet::class);
    }
}
