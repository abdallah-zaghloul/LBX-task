<?php

namespace Modules\Employee\Criteria;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Criteria\RequestCriteria as BaseCriteria;
class RequestCriteria extends BaseCriteria
{
    /**
     * @return void
     */
    protected function hydrateSearchParams()
    {
        $searchParamName = config('repository.criteria.params.search', 'search');
        $searchArray = explode(';', $this->request->get($searchParamName));
        $hydratedSearch = collect($searchArray)->filter()->implode(';');
        $this->request->merge([$searchParamName => $hydratedSearch]);
    }

    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return Builder|Model|mixed
     * @throws Exception
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $this->hydrateSearchParams();
        return parent::apply($model, $repository);
    }
}
