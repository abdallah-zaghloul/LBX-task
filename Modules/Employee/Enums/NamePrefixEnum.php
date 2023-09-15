<?php

namespace Modules\Employee\Enums;

use Modules\Employee\Traits\EnumToArray;

enum NamePrefixEnum : string
{
    use EnumToArray;

    case Mrs = "Mrs.";
    case Mr = "Mr.";
    case Ms = "Ms.";
    case Dr = "Dr.";
    case Hon = "Hon.";
    case Drs = "Drs.";
    case Prof = "Prof.";
}
