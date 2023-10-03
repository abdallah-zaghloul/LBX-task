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
    protected function hydrateQueryParams()
    {
        collect([
            config('repository.criteria.params.search', 'search'),
            config('repository.criteria.params.searchFields', 'searchFields'),
            config('repository.criteria.params.filter', 'filter'),
            config('repository.criteria.params.orderBy', 'orderBy'),
            config('repository.criteria.params.searchJoin', 'searchJoin'),
        ])->each(fn($param) => $this->hydrateParam($param));

        $sortedByParam = config('repository.criteria.params.sortedBy', 'sortedBy');
        if (!in_array($this->request->get($sortedByParam), ['asc','desc'])) unset($this->request[$sortedByParam]);
    }

    /**
     * @param $paramName
     * @return void
     */
    protected function hydrateParam($paramName)
    {
        $values = explode(';', $this->request->get($paramName));
        $hydratedValues = ($filtered = collect($values)->filter())->implode(';');
        $filtered->isNotEmpty() and $this->request->merge([$paramName => $hydratedValues]);
    }

    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return Builder|Model|mixed
     * @throws Exception
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $this->hydrateQueryParams();
        return parent::apply($model, $repository);
    }
}
