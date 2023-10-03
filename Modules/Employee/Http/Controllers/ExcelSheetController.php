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
     * @OA\Get(
     *      path="/api/excelSheet/{id}",
     *      operationId="showExcelSheetById",
     *      tags={"ExcelSheet"},
     *      summary="Show ExcelSheet",
     *      description="Return ExcelSheet",
     *      operationId="showExcelSheet",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="excelSheetID as UUID like 9a4827a1-37ca-4222-b91b-3b551ba74d28",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *           )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *               @OA\Property(property="status", type="bool"),
     *               @OA\Property(property="message", type="string", default="Successfull operation."),
     *               @OA\Property(
     *                              property="data",
     *                              type="object",
     *                              @OA\Property(
     *                                              property="excel_sheet",
     *                                              type="object",
     *                                              default={
                                                                "id": "9a48014d-fcc9-44ac-a13d-c9e72645f284",
                                                                "path": "ExcelSheet/9a48014d-fcc9-44ac-a13d-c9e72645f284.csv",
                                                                "status": "Processing",
                                                                "errors": null,
                                                                "created_at": "03/10/2023 01:41:43 PM",
                                                                "updated_at": "03/10/2023 01:41:43 PM",
                                                                "url": "https://large-file-upload-laravel.s3.eu-central-1.amazonaws.com/ExcelSheet/9a48014d-fcc9-44ac-a13d-c9e72645f284.csv",
                                                                "updates_url": "http://localhost:8000/api/excelSheet/9a48014d-fcc9-44ac-a13d-c9e72645f284"
                                                    })
     *                        ),
     *               ),
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *               @OA\Property(property="status", type="bool", default=false),
     *               @OA\Property(property="message", type="string", default="Not found."),
     *          )
     *      ),
     *      @OA\Response(
     *          response=503,
     *          description="Unavailable Server",
     *          @OA\JsonContent(
     *               @OA\Property(property="status", type="bool", default=false),
     *               @OA\Property(property="message", type="string", default="Sorry something went wrong ... please try again later."),
     *          )
     *      ),
     * )
     *
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
