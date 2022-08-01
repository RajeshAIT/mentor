<?php

namespace App\Http\Controllers\Api;
use App\Models\Postmedia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class MediaImageController extends Controller
{
    public function mediaImage($post_id)
    {
    $profileImage=Postmedia::where('post_id',$post_id)->pluck('media_url')->first();
    $path = storage_path('public/post_media/' . $profileImage);
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

    public function mediaThumbnail($post_id)
    {
    $videoThumbnail=Postmedia::where('post_id',$post_id)->pluck('media_thumbnail')->first();
    $url = storage_path('public/post_media/thumbnail/' . $videoThumbnail);
    if (!File::exists($url))
    {
        abort(404);
    }
    $file = File::get($url);
    $type = File::mimeType($url);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
    }
}