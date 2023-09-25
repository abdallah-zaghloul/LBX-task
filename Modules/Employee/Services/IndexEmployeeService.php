<?php /** @noinspection PhpUndefinedFieldInspection */

namespace Modules\Employee\Services;

/**
 *
 */
class IndexEmployeeService extends EmployeeService
{

    /**
     * @return mixed
     */
    public function execute(): mixed
    {
        return $this->employeeRepository->paginate();
    }
}
