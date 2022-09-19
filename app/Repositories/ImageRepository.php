<?php

namespace App\Repositories;

use App\Interfaces\ImageInterface;
use App\Models\Answer;
use App\Models\Company;
use App\Models\userProfile;
use App\Traits\ResponseAPI;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

use App\Traits\MimeTypeTrait;

use Storage;


class ImageRepository implements ImageInterface
{    
    use ResponseAPI;
    use MimeTypeTrait;
    
    
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
        

        $s3 = Storage::disk('s3')->getAdapter()->getClient();
        $path = $s3->getObjectUrl( env('AWS_BUCKET'), 'media/1661321424.mp4' );
        
        $stream = Storage::disk('s3')->getDriver()->readStream($path);
        $response = new StreamedResponse(function() use ($stream) {
            echo stream_get_contents($stream);
        });
        dd($response);

        $mime_type = self::getMimeType("1661321424.mp4");

        return Response::make(file_get_contents($path), 200, [
            'Content-Type' => $mime_type,
            "Content-Range" => "bytes 500-1000/65989",
            'Content-Disposition' => 'inline; filename=1661321424.mp4'
        ]);
    }

    public function profilephoto($id)
    {
        $profilePhoto = UserProfile::where('user_id',$id)->pluck('photo')->first();
        $path = storage_path('public/images/' . $profilePhoto);
        if (!File::exists($path)) {

            abort(404);
    
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }
}