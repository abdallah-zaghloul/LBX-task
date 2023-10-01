<?php
/** @noinspection PhpPureAttributeCanBeAddedInspection */
/** @noinspection PhpUndefinedFieldInspection */
/** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */

namespace Modules\Employee\Imports;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\LazyCollection;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Validators\Failure;
use Modules\Employee\Enums\ExcelSheetStatusEnum;
use Modules\Employee\Enums\GenderEnum;
use Modules\Employee\Enums\NamePrefixEnum;
use Modules\Employee\Models\ExcelSheet;
use Throwable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\ImportFailed;
/**
 *
 */
class EmployeeImportValidator extends HeadingRowFormatter implements
    WithHeadingRow,
    SkipsEmptyRows,
    WithChunkReading,
    ShouldQueue,
    ShouldBeUnique,
    SkipsOnError,
    SkipsOnFailure,
    WithValidation,
    ToCollection,
    WithEvents
//    WithUpsertColumns,
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use Importable;


    /**
     * @var array
     */
    protected array $regexRules;


    /**
     * @var ExcelSheet
     */
    public ExcelSheet $excelSheet;


    /**
     * @param ExcelSheet $excelSheet
     */
    public function __construct(ExcelSheet $excelSheet)
    {
        $this->excelSheet = $excelSheet->refresh();
        $this->regexRules = static::getRegexRules();
    }


    /**
     * @param Collection $collection
     * @return Collection
     */
    public function collection(Collection $collection): Collection
    {
        return $collection;
    }


    /**
     * @return string[]
     */
    public static function getRegexRules(): array
    {
        return [
            "alphabetic" => "alpha",
            "alphabeticNumberDashUnderscore" => "alpha_dash",
            "alphabeticSpaceDash" => "regex:/^[\pL\s\-]+$/u",
            "alphabeticSpaceDashDot" => "regex:/^[\pL\s\-\.]+$/u",
            "alphabeticSpaceDashDotApostrophe" => "regex:/^[\pL\s\-\.\']+$/u",
            "alphabeticSpaceDashDotApostropheParentheses" => "regex:/^[\pL\s\-\.\'\(\)]+$/u",
//            "zipCode" => "regex:/^(?:(\d{5})(?:[ \-](\d{4}))?)$/i",
            "zipCode" => "digits_between:3,5",
            "numberDash"=> "regex:/^[0-9-]+$/"
        ];
    }


    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            "id" => ["required", "integer", "distinct"],
            "user_name" => ["required", "string","distinct" , $this->regexRules["alphabeticNumberDashUnderscore"], "max:191"],
            "name_prefix" => ["required", Rule::in(NamePrefixEnum::values())],
            "first_name" => ["required", "string", $this->regexRules["alphabeticSpaceDash"], "max:191"],
            "middle_initial" => ["required", "string", $this->regexRules["alphabetic"], "max:1"],
            "last_name" => ["required", "string", $this->regexRules["alphabeticSpaceDash"], "max:191"],
            "gender" => ["required", Rule::in(GenderEnum::values())],
            "email" => ["required", "string", "email", "distinct", "max:191"],
            "date_of_birth" => ["required", "date"],
            "time_of_birth" => ["required", "date_format:h:i:s A,H:i:s"],
            "age_in_years" => ["required", "numeric", "min:0","max:100"],
            "date_of_joining" => ["required", "date"],
            "age_in_company" => ["required","numeric", "min:0","max:100"],
            "phone_no" => ["required","string", $this->regexRules["numberDash"], "max:16"],
            "place_name" => ["required","string", $this->regexRules["alphabeticSpaceDash"], "max:191"],
            "county" => ["required","string",$this->regexRules["alphabeticSpaceDashDotApostropheParentheses"], "max:191"],
            "city" => ["required","string",$this->regexRules["alphabeticSpaceDash"] ,"max:191"],
            "zip" => ["required", $this->regexRules["zipCode"]],
            "region" => ["required", $this->regexRules["alphabeticSpaceDash"] ,"max:191"],
        ];
    }


    /**
     * @return string[]
     */
    public function customValidationAttributes(): array
    {
        return [
            "id" => "Emp ID",
            "user_name" => "User Name",
            "name_prefix" => "Name Prefix",
            "first_name" => "First Name",
            "middle_initial" => "Middle Initial",
            "last_name" => "Last Name",
            "gender" => "Gender",
            "email" => "E mail",
            "date_of_birth" => "Date of Birth",
            "time_of_birth" => "Time of Birth",
            "age_in_years" => "Age in Yrs",
            "date_of_joining" => "Date of Joining",
            "age_in_company" => "Age in Company",
            "phone_no" => "Phone No",
            "place_name" => "Place Name",
            "county" => "County",
            "city" => "City",
            "zip" => "Zip",
            "region" => "Region",
        ];
    }



    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }


    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 1000;
    }



    /**
     * @return int
     */
    public function headingRow(): int
    {
        return 1;
    }


    /**
     * @param Throwable $e
     * @return void
     */
    public function onError(Throwable $e)
    {
       $this->setExcelSheetErrorStatus(ExcelSheetStatusEnum::Failed, $e->getTrace());
    }


    /**
     * @return Carbon
     */
    public function retryUntil(): Carbon
    {
        return now()->addSeconds(5);
    }


    /**
     * @param Failure ...$failures
     * @return void
     */
    public function onFailure(Failure ...$failures)
    {
        $errors = LazyCollection::make($failures)->mapWithKeys(
            fn(Failure $failure, $index) => collect($failure->errors())->transform(fn($error) => @trans(
                'employee::validation.excel_row', [
                    'row_number' => $failure->row(),
                    'message' => $error
            ]))
        )->flatten();

        $this->setExcelSheetErrorStatus(ExcelSheetStatusEnum::Invalid, $errors);
    }


    /**
     * @param ExcelSheetStatusEnum $status
     * @param iterable $errors
     * @return void
     */
    public function setExcelSheetErrorStatus(ExcelSheetStatusEnum $status, iterable $errors)
    {
        $this->excelSheet->update([
            'status' => $status,
            'errors' => $this->excelSheet->errors ? $this->excelSheet->errors->concat($errors) : $errors,
        ]);
    }

    public function registerEvents(): array
    {
        return [
            //Failed Import Event => Listener
            ImportFailed::class => function(ImportFailed $event) {
                $this->setExcelSheetErrorStatus(ExcelSheetStatusEnum::Failed, $event->getException()->getTrace());
            },
            //After Import Event => Listener
            AfterImport::class => function(AfterImport $event){
                ! $this->excelSheet->errors and $this->excelSheet->update(['status' => ExcelSheetStatusEnum::Valid]);
            }
        ];
    }
}
