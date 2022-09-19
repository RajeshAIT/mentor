<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Interfaces\CategoryInterface;

use App\Http\Requests\CategoryRequest;

class CategoriesController extends Controller
{
    protected $CategoryInterface;

    public function __construct(CategoryInterface $CategoryInterface)
    {
        $this->CategoryInterface = $CategoryInterface;
    }
    public function categorizethequestion ()
    {
       return $this->CategoryInterface->categorizethequestion();
    }

    public function store(CategoryRequest $request)
    {
        return $this->CategoryInterface->store($request);
    }
}
