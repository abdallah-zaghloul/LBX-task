<?php

namespace Modules\Employee\Traits;

use Illuminate\Support\Collection;

trait EnumIterable
{
    /**
     * @return array
     */
    public static function names(): array
    {
        return array_column(static::cases(), 'name');
    }

    /**
     * @return array
     */
    public static function values(): array
    {
        return array_column(static::cases(), 'value');
    }

    /**
     * @return array
     */
    public static function array(): array
    {
        return array_combine(static::names(), static::values());
    }

    /**
     * @return Collection
     */
    public static function collection(): Collection
    {
        return collect(static::cases());
    }
}
