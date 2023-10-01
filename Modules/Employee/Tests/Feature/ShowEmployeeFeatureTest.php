<?php

namespace Modules\Employee\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Employee\Database\Seeders\EmployeeDatabaseSeeder;
use Tests\TestCase;

class ShowEmployeeFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Feature test example.
     *
     * @return void
     */
    public function test_show_employee_feature()
    {
       $employee = app(EmployeeDatabaseSeeder::class)->run();
       $baseUrl = "api/employee";
       $response = $this->get("$baseUrl/$employee->id");
       $response->assertSuccessful();
       $employee->delete();
       $response = $this->get("$baseUrl/$employee->id");
       $response->assertNotFound();
    }
}
