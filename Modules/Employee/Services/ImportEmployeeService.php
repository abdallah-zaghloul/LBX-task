<?php /** @noinspection PhpUndefinedFieldInspection */

namespace Modules\Employee\Services;

use Modules\Employee\Enums\ExcelSheetStatusEnum;
use Modules\Employee\Http\Requests\ImportEmployeeRequest;
use Modules\Employee\Imports\EmployeeImporter;
use Modules\Employee\Imports\EmployeeImportValidator;
use Modules\Employee\Models\ExcelSheet;
use Throwable;

/**
 *
 */
class ImportEmployeeService extends EmployeeService
{

    /**
     * @var CreateExcelSheetService
     */
    private CreateExcelSheetService $createExcelSheetService;


    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->createExcelSheetService = app(CreateExcelSheetService::class);
    }


    /**
     * @param ImportEmployeeRequest $request
     * @return ExcelSheet
     * @throws Throwable
     */
    public function execute(ImportEmployeeRequest $request): ExcelSheet
    {
        $excelSheet = $this->createExcelSheetService->execute($request->file('employees'));
        $employeeImportValidator = app(EmployeeImportValidator::class, compact('excelSheet'));
        $employeeImporter = app(EmployeeImporter::class, compact('excelSheet'));

        $employeeImportValidator->queue($excelSheet->path)->chain([
            fn() => $excelSheet->refresh()->status === ExcelSheetStatusEnum::Valid and $employeeImporter->queue($excelSheet->path)
        ]);

        return $excelSheet;
    }
}
