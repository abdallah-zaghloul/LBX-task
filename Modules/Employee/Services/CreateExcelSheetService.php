<?php

namespace Modules\Employee\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Modules\Employee\Enums\ExcelSheetStatusEnum;
use Modules\Employee\Models\ExcelSheet;
use Modules\Employee\Traits\Response;
use Throwable;

class CreateExcelSheetService extends ExcelSheetService
{
    use Response;

    /**
     * @throws Throwable
     */
    public function execute(UploadedFile $uploadedFile): ExcelSheet
    {
        return $this->excelSheetRepository->create([
            'id' => Str::orderedUuid(),
            'path' => $uploadedFile,
            'status' => ExcelSheetStatusEnum::Processing
        ]);
    }
}
