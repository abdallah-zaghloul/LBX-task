<?php

namespace Modules\Employee\Services;

use Modules\Employee\Repositories\ExcelSheetRepository;
use Modules\Employee\Traits\Response;

/**
 *
 */
abstract class ExcelSheetService
{
    use Response;

    /**
     * @var ExcelSheetRepository
     */
    protected ExcelSheetRepository $excelSheetRepository;

    /**
     *
     */
    public function __construct()
    {
        $this->excelSheetRepository = app(ExcelSheetRepository::class);
    }

}
