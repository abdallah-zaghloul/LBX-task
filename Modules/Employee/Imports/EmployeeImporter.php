<?php
/** @noinspection PhpUndefinedFieldInspection */
/** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */

namespace Modules\Employee\Imports;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Modules\Employee\Models\Employee;
use Modules\Employee\Models\ExcelSheet;

/**
 *
 */
class EmployeeImporter extends EmployeeImportValidator implements
    ToModel,
    WithUpserts,
    WithBatchInserts
//    WithUpsertColumns,
{

    /**
     * @var array
     */
    protected array $modelAttributeNames;


    /**
     * @param ExcelSheet $excelSheet
     */
    public function __construct(ExcelSheet $excelSheet)
    {
        parent::__construct($excelSheet);
        $this->modelAttributeNames = static::getModelAttributeNames();
    }


    /**
     * @param array $row
     * @return Employee
     */
    public function model(array $row): Employee
    {
        return app(Employee::class)->fillable($this->modelAttributeNames)->fill([
            'id' => $row['id'] ?? $row['emp_id'],
            'user_name' => $row['user_name'],
            'name_prefix' => $row['name_prefix'],
            'first_name' => $row['first_name'],
            'middle_initial' => $row['middle_initial'],
            'last_name' => $row['last_name'],
            'gender' => $row['gender'],
            'email' => $row['email'] ?? $row['e_mail'],
            'date_of_birth' => $row['date_of_birth'],
            'time_of_birth' => $row['time_of_birth'],
            'age_in_years' => $row['age_in_years'] ?? $row['age_in_yrs'],
            'date_of_joining' => $row['date_of_joining'],
            'age_in_company' => $row['age_in_company'] ?? $row['age_in_company_years'],
            'phone_no' => $row['phone_no'],
            'place_name' => $row['place_name'],
            'county' => $row['county'],
            'city' => $row['city'],
            'zip' => $row['zip'],
            'region' => $row['region'],
            'excel_sheet_id' => $this->excelSheet->id
        ]);
    }


    /**
     * @return array
     */
    public static function getModelAttributeNames(): array
    {
        $table = app(Employee::class)->getTable();
        return collect(Schema::getColumnListing($table))->reject(fn($column) => in_array($column,['created_at','updated_at']))->all();
    }


    /**
     * @return string[]
     */
    public function uniqueBy(): array
    {
        return [
            'id',
            'user_name',
            'email'
        ];
    }

}
