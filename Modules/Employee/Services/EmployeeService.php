<?php

namespace Modules\Employee\Services;

use Modules\Employee\Repositories\EmployeeRepository;

abstract class EmployeeService
{
    protected EmployeeRepository $employeeRepository;

    public function __construct()
    {
        $this->employeeRepository = app(EmployeeRepository::class);
    }

}
