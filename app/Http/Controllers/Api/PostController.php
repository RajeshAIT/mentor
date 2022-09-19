<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\PostRequest;
use App\Interfaces\PostInterface;

class PostController extends Controller
{
    protected $postInterface;

    public function __construct(PostInterface $postInterface)
    {
        $this->postInterface = $postInterface;
    }
    
    public function store(PostRequest $request)
    {
        return $this->postInterface->requestPost($request);
    }

    public function show($id, $post_type_id)
    {
        return $this->postInterface->getPost($id, $post_type_id);
    }
}