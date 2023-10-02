<?php

namespace Modules\Employee\Repositories;

use Modules\Employee\Criteria\RequestCriteria;
use Modules\Employee\Models\Employee;
use Prettus\Repository\Eloquent\BaseRepository;
use function app;

/**
 * Class EmployeeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EmployeeRepositoryEloquent extends BaseRepository implements EmployeeRepository
{

    /**
     * @var string[]
     */
    protected $fieldSearchable = [
        'id',
        'user_name',
        'name_prefix',
        'first_name',
        'middle_initial',
        'last_name',
        'gender',
        'email',
        'date_of_birth',
        'time_of_birth',
        'age_in_years',
        'date_of_joining',
        'age_in_company',
        'phone_no',
        'place_name',
        'county',
        'city',
        'zip',
        'region',
        'created_at',
        'updated_at',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Employee::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
