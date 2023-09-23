<?php

namespace Modules\Employee\Enums;

use Modules\Employee\Traits\EnumIterable;

enum GenderEnum : string
{
    use EnumIterable;

    case Male = 'M';
    case Female = 'F';
}
