<?php

namespace App\Repositories;

use App\Model\Admin\Post;
use App\Model\Admin\PostLog;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
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
     * Specify Model class name
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
     * @param string $ip
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function saveLog(Post $post, string $action, string $ip)
    {
        $data['post_id']        = $post->id;
        $data['user_id']        = $post->user_id;
        $data['action']         = $action;
        $data['content']        = $post->content;
        $data['create_time']    = time();
        $data['title']          = $post->title;
        $data['desc']           = $post->desc;
        $data['ip']             = $ip;
        return $this->create($data);
    }
}
