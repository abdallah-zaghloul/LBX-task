<?php

namespace Modules\Employee\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class ImportEmployeeUnitTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Feature test example.
     *
     * @return void
     */
    public function test_import_employee_service()
    {
        $filePath = (module_path("employee")."/Resources/excel")."/".($name = "test.csv");
        $employees = new UploadedFile(path:  $filePath, originalName: $name, mimeType: 'text/csv', test: true);
        Excel::fake();
        $response = $this->post(uri: 'api/employee', data:  compact('employees'), headers:["content-type" => "multipart/form-data"]);
        $excelSheet = data_get($response->json(),'data.excel_sheet');
        Excel::assertQueued($excelSheet['path']);
    }
}
