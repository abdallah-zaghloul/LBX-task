<?php

namespace Modules\Employee\Services;

use Modules\Employee\Repositories\ExcelSheetRepository;

abstract class ExcelSheetService
{
    protected ExcelSheetRepository $excelSheetRepository;

    public function __construct()
    {
        $this->excelSheetRepository = app(ExcelSheetRepository::class);
    }

}
