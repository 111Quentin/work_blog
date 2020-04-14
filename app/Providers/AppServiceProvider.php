<?php

namespace App\Providers;

use App\Criteria\RoleCriteria;
use App\Criteria\SearchCriteria;
use App\Models\Admin\Post;
use App\Observers\PostObserver;
use Illuminate\Support\ServiceProvider;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Providers\RepositoryServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //监视Post模块事件
        Post::observe(PostObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //注册全局Criteria
        $this->app->afterResolving(RepositoryCriteriaInterface::class,
            function(RepositoryCriteriaInterface $object, $app) {
                $object->pushCriteria($app->make(RoleCriteria::class))
                ->pushCriteria($app->make(SearchCriteria::class));
            });
    }
}
