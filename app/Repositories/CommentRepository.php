<?php

namespace App\Repositories;

use App\Comment;

class CommentRepository extends Repository {

    public function __construct(Comment $model){
        $this->model = $model;
    }
}
