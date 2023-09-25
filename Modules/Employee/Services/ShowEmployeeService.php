<?php /** @noinspection PhpUndefinedFieldInspection */

namespace Modules\Employee\Services;

/**
 *
 */
class ShowEmployeeService extends EmployeeService
{

    /**
     * @param string|int $id
     * @return mixed
     */
    public function execute(string|int $id)
    {
        return $this->employeeRepository->find($id);
    }
}
