<?php

namespace Modules\Employee\Repositories;

use App\Validators\ExcelSheetValidator;
use Modules\Employee\Models\ExcelSheet;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use function app;

/**
 * Class ExcelSheetRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ExcelSheetRepositoryEloquent extends BaseRepository implements ExcelSheetRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ExcelSheet::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
