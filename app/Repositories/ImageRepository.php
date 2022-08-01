<?php

namespace App\Repositories;

use App\Interfaces\ImageInterface;
use App\Models\Answer;
use App\Models\Company;
use App\Models\userProfile;
use App\Traits\ResponseAPI;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class ImageRepository implements ImageInterface
{    
    use ResponseAPI;
    
    
    public function displayImage($id)
    {
    $profileLogo=Company::where('id',$id)->pluck('logo')->first();
    $path = storage_path('public/logo/' . $profileLogo);
   
    if (!File::exists($path))
    {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
    }
    
    public function companyLogo($id)
    {
        $CompanyLogo = Company::where('id',$id)->pluck('logo')->first();
        $path = storage_path('/public/logo/' . $CompanyLogo);
        if (!File::exists($path))
    {
        abort(404);
    }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    public function mediafile($id)
    {
        $Answermedia = Answer::where('id',$id)->pluck('media')->first();
        $path = storage_path('/public/media/' . $Answermedia);
        if (!File::exists($path))
    {
        abort(404);
    }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    public function profilephoto($id)
    {
        $profilePhoto = UserProfile::where('user_id',$id)->pluck('photo')->first();
        $path = storage_path('/public/images/' . $profilePhoto);
        if (!File::exists($path))
    {
        abort(404);
    }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }
}