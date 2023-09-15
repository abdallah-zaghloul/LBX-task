<?php

namespace Modules\Employee\Enums;

use Modules\Employee\Traits\EnumToArray;

enum RegionEnum : string
{
    use EnumToArray;

    case Northeast = 'Northeast';
    case South = 'South';
    case West = 'West';
    case Midwest = 'Midwest';
}
