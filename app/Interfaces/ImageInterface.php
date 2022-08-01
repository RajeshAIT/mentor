<?php 

namespace App\Interfaces;

interface ImageInterface
{
    public function displayImage($id);

    public function companyLogo($id);

    public function mediafile($id);

    public function profilephoto($id);
}