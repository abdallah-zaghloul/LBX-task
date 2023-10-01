<?php
/** @noinspection PhpUndefinedMethodInspection */

namespace Modules\Employee\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Modules\Employee\Enums\GenderEnum;
use Modules\Employee\Enums\NamePrefixEnum;
use Modules\Employee\Models\Employee;

class EmployeeDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return Employee
     */
    public function run(): Employee
    {
        [$id, $user_name, $email] = [198429, 'sibumgarner', 'serafina.bumgarner@exxonmobil.com'];
        return app(Employee::class)->updateOrCreate(compact('id','user_name','email'), [
            'id' => $id,
            'user_name' => $user_name,
            'name_prefix' => NamePrefixEnum::Mrs,
            'first_name' => 'Serafina',
            'middle_initial' => 'I',
            'last_name' => 'Bumgarner',
            'gender' => GenderEnum::Female,
            'email' => $email,
            'date_of_birth' => Carbon::parse('9/21/1982'),
            'time_of_birth' => Carbon::parse('01:53:14 AM'),
            'age_in_years' => '34.87',
            'date_of_joining' => Carbon::parse('2/1/2008'),
            'age_in_company' => '9.49',
            'phone_no' => '212-376-9125',
            'place_name' => 'Clymer',
            'county' => 'Chautauqua',
            'city' => 'Clymer',
            'zip' => '14724',
            'region' => 'Northeast',
        ]);
    }
}
