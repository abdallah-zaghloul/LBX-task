<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Employee\Http\Requests\ImportEmployeeRequest;
use Modules\Employee\Services\ImportEmployeeService;
use Modules\Employee\Traits\Response;
use Throwable;

class EmployeeController extends Controller
{
    use Response;

    /**
     * @param ImportEmployeeRequest $request
     * @param ImportEmployeeService $service
     * @return JsonResponse
     * @throws Throwable
     */
    public function import(ImportEmployeeRequest $request, ImportEmployeeService $service): JsonResponse
    {
        $excel_sheet = $service->execute($request);
        return $this->dataResponse(data:  compact('excel_sheet'), message: @trans('employee::messages.processing'));
    }
}
