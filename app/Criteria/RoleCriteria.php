<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Model\Admin\User;
use Auth;

/**
 * Class RoleCriteria.
 *
 * @package namespace App\Criteria;
 */
class RoleCriteria implements CriteriaInterface
{

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
        return $model->byRole(Auth::id());
    }
}
