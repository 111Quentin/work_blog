<?php

namespace App\Criteria;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class SearchCriteria.
 *
 * @package namespace App\Criteria;
 */
class SearchCriteria implements CriteriaInterface
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $search  = $this->request->all();
        $searchs = $search['search'] ?? [];
        dd($search);
        $searchable = $repository->getSearchable();

        foreach($searchs as $field => $value)
        {
            if (in_array($field, array_keys($searchable))) {
                $oper = $searchable[$field];
                switch ($oper) {
                    case 'like':
                        $model->where($field, 'like', '%'.$value.'%');
                        break;
                }
                $method = 'search'.ucfirst($oper);
                if (method_exists($repository, $method)) {
                    call_user_func([$repository, $method], $model, $value);
                }
            }
        }

        return $model;
    }
}
