<?php /** @noinspection PhpUndefinedFieldInspection */

namespace Modules\Employee\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Employee\Enums\ExcelSheetStatusEnum;
use Modules\Employee\Models\ExcelSheet;
use Modules\Employee\Repositories\EmployeeRepository;

/**
 *
 */
class UpdateExcelSheetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * @var ExcelSheet
     */
    private ExcelSheet $excelSheet;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ExcelSheet $excelSheet)
    {
        $this->excelSheet = $excelSheet->refresh();
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!empty($this->excelSheet->errors))
            app(EmployeeRepository::class)->where('excel_sheet_id', '=', $this->excelSheet->id)->delete();

        else $this->excelSheet->update(['status'=> ExcelSheetStatusEnum::Imported]);
    }
}
