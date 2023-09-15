<?php

namespace Modules\Employee\Enums;

use Modules\Employee\Traits\EnumToArray;

enum GenderEnum : string
{
    use EnumToArray;

    case Male = 'M';
    case Female = 'F';
}
