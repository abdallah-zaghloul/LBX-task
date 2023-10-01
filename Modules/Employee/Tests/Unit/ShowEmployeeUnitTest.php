<?php

namespace Modules\Employee\Tests\Unit;

use Modules\Employee\Database\Seeders\EmployeeDatabaseSeeder;
use Modules\Employee\Services\ShowEmployeeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowEmployeeUnitTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_show_employee_service()
    {
        $employee = app(EmployeeDatabaseSeeder::class)->run();
        $result = app(ShowEmployeeService::class)->execute($employee->id);
        $this->assertEquals($employee->user_name, $result->user_name);
        $employee->delete();
    }
}
