<?php

namespace Modules\Employee\Services;

use Modules\Employee\Models\ExcelSheet;
use Modules\Employee\Traits\Response;
use Throwable;

class ShowExcelSheetService extends ExcelSheetService
{
    use Response;

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
