<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class PostRepository.
 */
class PostRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Post::class;
    }

    public function getByUser(User $user)
    {
        return $this->model->where('user_id', $user->id)->get();
    }
}
