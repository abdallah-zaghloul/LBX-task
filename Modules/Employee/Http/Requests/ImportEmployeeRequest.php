<?php

namespace Modules\Employee\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Employee\Traits\Response;

class ImportEmployeeRequest extends FormRequest
{
    use Response;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return void
     */
    protected function prepareForValidation()
    {
        !empty($employeesFile = $this->file('employees')) and $this->merge(['extension' => $employeesFile->getClientOriginalExtension()]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "employees" => ["required","file","mimes:csv",'mimetypes:text/csv',"max:10240"],
            "extension" => ["required", Rule::in("csv")],
        ];
    }

    /**
     * @param Validator $validator
     * @return mixed|void
     */
    public function failedValidation(Validator $validator)
    {
        return $this->errorResponse($validator->errors()->all());
    }
}
