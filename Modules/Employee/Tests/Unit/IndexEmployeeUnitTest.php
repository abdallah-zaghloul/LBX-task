<?php

namespace Modules\Employee\Tests\Unit;

use Modules\Employee\Database\Seeders\EmployeeDatabaseSeeder;
use Modules\Employee\Services\IndexEmployeeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexEmployeeUnitTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_index_employee_service()
    {
        $employee = app(EmployeeDatabaseSeeder::class)->run();
        $result = app(IndexEmployeeService::class)->execute();
        $this->assertNotEmpty($result);
        $employee->delete();
    }
}
