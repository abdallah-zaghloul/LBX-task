<?php

namespace Modules\Employee\Tests\Unit;

use Modules\Employee\Database\Seeders\EmployeeDatabaseSeeder;
use Modules\Employee\Services\DeleteEmployeeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteEmployeeUnitTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_delete_employee_service()
    {
        $employee = app(EmployeeDatabaseSeeder::class)->run();
        $result = app(DeleteEmployeeService::class)->execute($employee->id);
        $this->assertTrue($result);
    }
}
