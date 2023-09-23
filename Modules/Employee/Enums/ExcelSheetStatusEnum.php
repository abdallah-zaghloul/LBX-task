<?php

namespace Modules\Employee\Enums;

use Modules\Employee\Traits\EnumIterable;

enum ExcelSheetStatusEnum : string
{
    use EnumIterable;

    case Processing = 'Processing';
    case Imported = 'Imported';
    case Invalid = 'Invalid';
    case Valid = 'Valid';
    case Failed = 'Failed';
}
