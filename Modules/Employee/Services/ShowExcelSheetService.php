<?php

namespace Modules\Employee\Services;

use Modules\Employee\Models\ExcelSheet;
use Throwable;

class ShowExcelSheetService extends ExcelSheetService
{
    /**
     * @param string|int $id
     * @return ExcelSheet
     * @throws Throwable
     */
    public function execute(string|int $id): ExcelSheet
    {
        return $this->excelSheetRepository->find($id);
    }
}
