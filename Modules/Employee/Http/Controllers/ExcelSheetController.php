<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Employee\Services\ShowExcelSheetService;
use Modules\Employee\Traits\Response;
use Throwable;

class ExcelSheetController extends Controller
{
    use Response;


    /**
     * @param string|int $id
     * @param ShowExcelSheetService $service
     * @return JsonResponse
     * @throws Throwable
     */
    public function __invoke(string|int $id, ShowExcelSheetService $service): JsonResponse
    {
        $excel_sheet = $service->execute($id);
        return $this->dataResponse(compact('excel_sheet'));
    }
}
