<?php

namespace Modules\Employee\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Employee\Http\Requests\ImportEmployeeRequest;
use Modules\Employee\Services\ImportEmployeeService;
use Tests\TestCase;

class ImportEmployeeFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Feature test example.
     *
     * @return void
     */
    public function test_import_employee_feature()
    {
        $filePath = (module_path("employee")."/Resources/excel")."/".($name = "test.csv");
        $employees = new UploadedFile(path:  $filePath, originalName: $name, mimeType: 'text/csv', test: true);
        $importEmployeeRequest = new ImportEmployeeRequest();
        $importEmployeeRequest->headers->set('content-type',"multipart/form-data");
        $importEmployeeRequest->files->set('employees', $employees);
        Excel::fake();
        $excelSheet = app(ImportEmployeeService::class)->execute($importEmployeeRequest);
        Excel::assertQueued($excelSheet->path);
    }
}
