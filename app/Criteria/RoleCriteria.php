<?php

namespace App\Criteria;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Model\Admin\User;

/**
 * Class RoleCriteria.
 *
 * @package namespace App\Criteria;
 */
class RoleCriteria implements CriteriaInterface
{
    protected $request;


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
        $user = new User();
        if ($user->isAdmin()) {
            return $model;
        }
        return $model->byRole($user);
    }
}
