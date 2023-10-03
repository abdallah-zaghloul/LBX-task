<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Employee\Http\Requests\ImportEmployeeRequest;
use Modules\Employee\Services\DeleteEmployeeService;
use Modules\Employee\Services\ImportEmployeeService;
use Modules\Employee\Services\IndexEmployeeService;
use Modules\Employee\Services\ShowEmployeeService;
use Modules\Employee\Traits\Response;
use Throwable;
/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="LBX Task Documentation",
 *      description="Implement Employee CRUD With Excel Sheet Import",
 *      @OA\Contact(
 *          email="3bdallahzaghloul@gmail.com",
 *          url="https://www.linkedin.com/in/abdallah-zaghloul"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="https://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * @OA\Tag(
 *     name="Employee",
 *     description="API Endpoints"
 * )
 *
 */
class EmployeeController extends Controller
{
    use Response;


    /**
     *  @OA\Post(
     *      path="/api/employee",
     *      operationId="importEmployeesList",
     *      tags={"Employee"},
     *      summary="Import list of employees",
     *      description="Import list of employees",
     *      operationId="importEmployee",
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="multipart/form-data",
     *          @OA\Schema(required={"employees"}, @OA\Property(property="employees", type="file")))
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", default="Your file is being processed ... please visit the updates url 10 min later or check your mail."),
     *              @OA\Property(
     *                              property="data",
     *                              type="object",
     *                              @OA\Property(property="excel_sheet",
     *                                  default={
                                                    "id": "9a48014d-fcc9-44ac-a13d-c9e72645f284",
                                                    "path": "ExcelSheet/9a48014d-fcc9-44ac-a13d-c9e72645f284.csv",
                                                    "status": "Processing",
                                                    "errors": null,
                                                    "created_at": "03/10/2023 01:41:43 PM",
                                                    "updated_at": "03/10/2023 01:41:43 PM",
                                                    "url": "https://large-file-upload-laravel.s3.eu-central-1.amazonaws.com/ExcelSheet/9a48014d-fcc9-44ac-a13d-c9e72645f284.csv",
                                                    "updates_url": "http://localhost:8000/api/excelSheet/9a48014d-fcc9-44ac-a13d-c9e72645f284"
     *                                           }
     *                                 )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *          @OA\JsonContent(
     *               @OA\Property(property="status", type="bool", default=false),
     *               @OA\Property(property="message", type="string", default="Please insert a valid data."),
     *               @OA\Property(
     *                  property="errors",
     *                  type="object",
     *                  default={
                                    "The employees field must be a file of type: csv.",
                                    "The employees field must be a file of type: text/csv."
     *                          }
     *              ),
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
     *  )
     *
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
     * @OA\Get(
     *      path="/api/employee",
     *      operationId="getEmployeesList",
     *      tags={"Employee"},
     *      summary="Get list of Employees",
     *      description="Returns list of Employees",
     *      operationId="indexEmployee",
     *     @OA\Parameter(
     *          name="searchJoin",
     *          in="query",
     *          description="Search query condition [and,or]",
     *          required=false,
     *         @OA\Schema(
     *            type="string",
     *            default="or",
     *            enum={"and","or"},
     *         )
     *      ),
     *      @OA\Parameter(
     *          name="search",
     *          in="query",
     *          description="Semi-colon separated pairs as Column_1:SearchValue_1;Column_2:SearchValue_2 with no space between it,
                            date should be in Y-m-d format  1982-09-21,
                            time should be in H:i:s format   13:53:14",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              default="id:198429;user_name:sibumgarner;date_of_joining:2008-02-01;time_of_birth:08:23:23;email:claude.boykins@hotmail.com",
     *           )
     *      ),
     *     @OA\Parameter(
     *          name="filter",
     *          in="query",
     *          description="The Returned Columns Selection ... semi-colon separated columns as id;user_name",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              default="id;user_name",
     *           )
     *      ),
     *     @OA\Parameter(
     *          name="searchFields",
     *          in="query",
     *          description="Semi-colon separated pairs as Column_1:SearchOperator_1;Column_2:SearchOperator_2 with no space between it,
                            email:like,
                            id:=
                when use (in,between) you should write search comma separated ... if not inserted the default foreach search param is =",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              default="id:=;user_name:like;date_of_joining:like;time_of_birth:=;email:like",
     *           )
     *      ),
     *     @OA\Parameter(
     *          name="orderBy",
     *          in="query",
     *          description="The Order By column",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              default="updated_at",
     *           )
     *      ),
     *     @OA\Parameter(
     *          name="sortBy",
     *          in="query",
     *          description="The Sort By direction",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              default="desc",
     *              enum={"asc","desc"},
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
     *                              @OA\Property(property="employees", type="object", default={
                                                 "current_page": 1,
                                                 "data": {
                                                                {
                                                                    "id": 198429,
                                                                    "user_name": "sibumgarner",
                                                                    "name_prefix": "Mrs.",
                                                                    "first_name": "Serafina",
                                                                    "middle_initial": "I",
                                                                    "last_name": "Bumgarner",
                                                                    "gender": "F",
                                                                    "email": "serafina.bumgarner@exxonmobil.com",
                                                                    "date_of_birth": "21/09/1982",
                                                                    "time_of_birth": "01:53:14 AM",
                                                                    "age_in_years": "34.87",
                                                                    "date_of_joining": "01/02/2008",
                                                                    "age_in_company": "9.49",
                                                                    "phone_no": "212-376-9125",
                                                                    "place_name": "Clymer",
                                                                    "county": "Chautauqua",
                                                                    "city": "Clymer",
                                                                    "zip": "14724",
                                                                    "region": "Northeast",
                                                                    "created_at": "01/10/2023 08:41:01 AM",
                                                                    "updated_at": "01/10/2023 08:41:01 AM"
                                                                }
                                                            },
                                                                "first_page_url": "http://127.0.0.1:8000/api/employee?search=id%3A198429&page=1",
                                                                "from": 1,
                                                                "last_page": 1,
                                                                "last_page_url": "http://127.0.0.1:8000/api/employee?search=id%3A198429&page=1",
                                                                "links": {
                                                                            {
                                                                                "url": null,
                                                                                "label": "&laquo; Previous",
                                                                                "active": false
                                                                            },
                                                                            {
                                                                                "url": "http://127.0.0.1:8000/api/employee?search=id%3A198429&page=1",
                                                                                "label": "1",
                                                                                "active": true
                                                                            },
                                                                            {
                                                                                "url": null,
                                                                                "label": "Next &raquo;",
                                                                                "active": false
                                                                            }
                                                                        },
                                                            "next_page_url": null,
                                                            "path": "http://127.0.0.1:8000/api/employee",
                                                            "per_page": 15,
                                                            "prev_page_url": null,
                                                            "to": 1,
                                                            "total": 1
                                                 })
     *               ),
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *          @OA\JsonContent(
     *               @OA\Property(property="status", type="bool", default=false),
     *               @OA\Property(property="message", type="string", default="Please insert a valid data."),
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
     * @param IndexEmployeeService $service
     * @return JsonResponse
     */
    public function index(IndexEmployeeService $service): JsonResponse
    {
        $employees = $service->execute();
        return $this->dataResponse(data:  compact('employees'));
    }



    /**
     * @OA\Get(
     *      path="/api/employee/{id}",
     *      operationId="showEmployeeById",
     *      tags={"Employee"},
     *      summary="Show Employee",
     *      description="Return employee",
     *      operationId="showEmployee",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="employeeID",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              default="198429",
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
     *                              @OA\Property(property="employee", type="object", default={
                                                    "id": 198429,
                                                    "user_name": "sibumgarner",
                                                    "name_prefix": "Mrs.",
                                                    "first_name": "Serafina",
                                                    "middle_initial": "I",
                                                    "last_name": "Bumgarner",
                                                    "gender": "F",
                                                    "email": "serafina.bumgarner@exxonmobil.com",
                                                    "date_of_birth": "21/09/1982",
                                                    "time_of_birth": "01:53:14 AM",
                                                    "age_in_years": "34.87",
                                                    "date_of_joining": "01/02/2008",
                                                    "age_in_company": "9.49",
                                                    "phone_no": "212-376-9125",
                                                    "place_name": "Clymer",
                                                    "county": "Chautauqua",
                                                    "city": "Clymer",
                                                    "zip": "14724",
                                                    "region": "Northeast",
                                                    "created_at": "01/10/2023 08:41:01 AM",
                                                    "updated_at": "01/10/2023 08:41:01 AM"
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
     * @param ShowEmployeeService $service
     * @return JsonResponse
     */
    public function show(string|int $id, ShowEmployeeService $service): JsonResponse
    {
        $employee = $service->execute($id);
        return $this->dataResponse(data:  compact('employee'));
    }



    /**
     * @OA\Delete(
     *      path="/api/employee/{id}",
     *      operationId="deleteEmployeeById",
     *      tags={"Employee"},
     *      summary="Delete Employee",
     *      description="Delete employee",
     *      operationId="deleteEmployee",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="employeeID",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              default="198429",
     *           )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *               @OA\Property(property="status", type="bool"),
     *               @OA\Property(property="message", type="string", default="Successfull operation."),
     *               @OA\Property(property="data", type="object", default={
                                                "delete":true
                                        }),
     *            ),
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
     * @param string|int $id
     * @param DeleteEmployeeService $service
     * @return JsonResponse
     */
    public function delete(string|int $id, DeleteEmployeeService $service): JsonResponse
    {
        $delete = $service->execute($id);
        return $this->dataResponse(data:  compact('delete'));
    }
}
