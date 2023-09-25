<?php

namespace Modules\Employee\Services;

use Modules\Employee\Repositories\EmployeeRepository;
use Modules\Employee\Traits\Response;

/**
 *
 */
abstract class EmployeeService
{
    use Response;

    /**
     * @var EmployeeRepository
     */
    protected EmployeeRepository $employeeRepository;

    /**
     *
     */
    public function __construct()
    {
        $this->employeeRepository = app(EmployeeRepository::class);
    }

}
