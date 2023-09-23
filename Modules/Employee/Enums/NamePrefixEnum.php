<?php

namespace Modules\Employee\Enums;

use Modules\Employee\Traits\EnumIterable;

enum NamePrefixEnum : string
{
    use EnumIterable;

    case Mrs = "Mrs.";
    case Mr = "Mr.";
    case Ms = "Ms.";
    case Dr = "Dr.";
    case Hon = "Hon.";
    case Drs = "Drs.";
    case Prof = "Prof.";
}
