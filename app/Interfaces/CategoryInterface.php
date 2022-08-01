<?php 

namespace App\Interfaces;

use App\Http\Requests\CategoryRequest;

interface CategoryInterface
{
    public function categorizethequestion ();

    public function store(CategoryRequest $request);
}