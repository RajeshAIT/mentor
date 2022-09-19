<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Interfaces\ImageInterface;

class ImageController extends Controller
{

    protected $ImageInterface;
    

    public function __construct(ImageInterface $ImageInterface)
    {
        $this->ImageInterface = $ImageInterface;
    }

    public function displayImage($id)
    {
        return $this->ImageInterface->displayImage($id);
    }

    public function companyLogo($id)
    {
        return $this->ImageInterface->companyLogo($id);
    }

    public function profilephoto($id)
    {
        return $this->ImageInterface->profilephoto($id);
    }

    public function mediafile($id)
    {
     return $this->ImageInterface->mediafile($id);
     }
}