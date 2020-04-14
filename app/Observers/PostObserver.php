<?php

namespace App\Observers;

use App\Models\Admin\Post;
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


    public function created(Post $post)
    {
        return $this->postLogRepository->saveLog(
            $post,
            'insert',
            $this->request->getClientIp()
        );
    }


    public function updated(Post $post)
    {
        return $this->postLogRepository->saveLog(
            $post,
            'update',
            $this->request->getClientIp()
        );
    }


    public function deleted(Post $post)
    {
        return $this->postLogRepository->saveLog(
            $post,
            'delete',
            $this->request->getClientIp()
        );
    }


    /**
     * Handle the post "restored" event.
     *
     * @param  \App\Models\Admin\Post  $post
     * @return void
     */
    public function restored(Post $post)
    {
        //
    }

    /**
     * Handle the post "force deleted" event.
     *
     * @param  \App\Models\Admin\Post  $post
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        //
    }
}
