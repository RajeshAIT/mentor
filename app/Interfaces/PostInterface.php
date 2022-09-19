<?php

namespace App\Interfaces;

use App\Http\Requests\PostRequest;

interface PostInterface
{
    public function requestPost(PostRequest $request);

    public function getPost($id, $post_type_id);
}