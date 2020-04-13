<?php

namespace App\Observers;

use App\Model\Admin\Post;
use App\Repositories\PostLogRepository;
use Illuminate\Http\Request;

class PostObserver
{
    /**
     * @var \App\Repositories\PostLogRepository
     */
    protected $postLogRepository;

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    public function __construct(PostLogRepository $postLogRepository, Request $request)
    {
        $this->postLogRepository = $postLogRepository;
        $this->request = $request;
    }

    /**
     * Handle the post "created" event.
     *
     * @param  \App\Model\Admin\Post  $post
     * @return void
     */
    public function created(Post $post)
    {
        return $this->postLogRepository->saveLog(
            $post,
            'insert',
            $this->request->getClientIp()
        );
    }

    /**
     * Handle the post "updated" event.
     *
     * @param  \App\Model\Admin\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        //
    }

    /**
     * Handle the post "deleted" event.
     *
     * @param  \App\Model\Admin\Post  $post
     * @return void
     */
    public function deleted(Post $post)
    {
        //
    }

    /**
     * Handle the post "restored" event.
     *
     * @param  \App\Model\Admin\Post  $post
     * @return void
     */
    public function restored(Post $post)
    {
        //
    }

    /**
     * Handle the post "force deleted" event.
     *
     * @param  \App\Model\Admin\Post  $post
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        //
    }
}