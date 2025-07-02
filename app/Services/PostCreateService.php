<?php

namespace App\Services;

use App\Models\Post;
use App\Validators\PostValidator;

class PostCreateService
{
    public function createPost(array $data): Post
    {
        PostValidator::validateCreate($data);
        return Post::create($data);
    }
}
?>