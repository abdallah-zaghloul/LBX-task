<?php

namespace Modules\Employee\Enums;

use Modules\Employee\Traits\EnumIterable;

enum RegionEnum : string
{
    use EnumIterable;

    case Northeast = 'Northeast';
    case South = 'South';
    case West = 'West';
    case Midwest = 'Midwest';
}
