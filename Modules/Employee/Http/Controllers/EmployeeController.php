<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Employee\Http\Requests\ImportEmployeeRequest;
use Modules\Employee\Services\ImportEmployeeService;
use Modules\Employee\Services\IndexEmployeeService;
use Modules\Employee\Services\ShowEmployeeService;
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


    /**
     * @param IndexEmployeeService $service
     * @return JsonResponse
     */
    public function index(IndexEmployeeService $service): JsonResponse
    {
        $employees = $service->execute();
        return $this->dataResponse(data:  compact('employees'));
    }

    /**
     * @param string|int $id
     * @param ShowEmployeeService $service
     * @return JsonResponse
     */
    public function show(string|int $id, ShowEmployeeService $service): JsonResponse
    {
        $employee = $service->execute($id);
        return $this->dataResponse(data:  compact('employee'));
    }
}
