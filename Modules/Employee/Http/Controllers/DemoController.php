<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Modules\Employee\Traits\Response;
use Throwable;

class DemoController extends Controller
{
    use Response;


    /**
     *  @OA\Post(
     *      path="/api/demo/truncateDB",
     *      operationId="truncateDB",
     *      tags={"Demo"},
     *      summary="Truncate DB",
     *      description="Truncate DB ... this api created for demo purpose only not for the unit test as test has its own in memory separated DB",
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *               @OA\Property(property="status", type="bool", default=true),
     *               @OA\Property(property="message", type="string", default="Database truncated successfully"),
     *               @OA\Property(property="data", type="object", default={
                                                         "Dropping all tables ........................................... 3,296ms DONE",
                                                         "INFO  Preparing database.",
                                                         "Creating migration table ........................................ 650ms DONE",
                                                         "INFO  Running migrations.",
                                                         "2014_10_12_000000_create_users_table ............................ 929ms DONE",
                                                         "2014_10_12_100000_create_password_reset_tokens_table ............ 920ms DONE",
                                                         "2019_08_19_000000_create_failed_jobs_table ...................... 900ms DONE",
                                                         "2019_12_14_000001_create_personal_access_tokens_table ......... 1,230ms DONE",
                                                         "2023_09_15_001437_create_excel_sheets_table ..................... 830ms DONE",
                                                         "2023_09_18_061522_create_jobs_table ............................. 830ms DONE",
                                                         "2023_09_18_062110_create_job_batches_table ...................... 859ms DONE",
                                                         "2023_09_19_074833_create_employees_table ...................... 1,630ms DONE"
     *                            }),
     *          )
     *      ),
     *     @OA\Response(
     *          response=503,
     *          description="Unavailable Server",
     *          @OA\JsonContent(
     *               @OA\Property(property="status", type="bool", default=false),
     *               @OA\Property(property="message", type="string", default="Sorry something went wrong ... please try again later."),
     *          )
     *      ),
     *  )
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function truncateDB(): JsonResponse
    {
        Artisan::call("migrate:fresh --force");
        $data = $this->getConsoleOutputArray(Artisan::output());
        return $this->dataResponse(data:  $data, message:  "Database truncated successfully");
    }


    /**
     * @param string $consoleOutput
     * @return array
     */
    private function getConsoleOutputArray(string $consoleOutput): array
    {
        return collect(explode(PHP_EOL, $consoleOutput))->filter()->transform(fn($line) => trim($line))->values()->all();
    }
}
