<?php

namespace App\Repositories;

use App\Models\Admin\Post;
use App\Models\Admin\PostLog;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Repositories\PostLogRepositoryRepository;
use App\Validators\PostLogRepositoryValidator;

/**
 * Class PostLogRepository.
 *
 * @package namespace App\Repositories;
 */
class PostLogRepository extends BaseRepository
{
    /**
     * Specify Models class name
     *
     * @return string
     */
    public function model()
    {
        return PostLog::class;
    }

    /**
     * 写入博客日志
     * @param Post $post
     * @param string $action
     * @param string $cycle
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public  function saveLog(Post $post, string $action, string $cycle)
    {
        $data['post_id']        = $post->id ? : 0;
        $data['user_id']        = $post->user_id;
        $data['action']         = $action;
        $data['cycle']          = $cycle;
        $data['content']        = $post->content;
        $data['title']          = $post->title;
        $data['desc']           = $post->desc;
        $data['ip']             = $_SERVER['REMOTE_ADDR'];
        $data['create_time']    = time();
        return $this->create($data);
    }
}
