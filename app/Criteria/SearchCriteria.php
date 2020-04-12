<?php

namespace App\Criteria;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Model\Admin\Post;

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
        $key = $this->request->query('query') ? $this->request->query('query') : '';
        return $model->bySearch($key);
    }

}
