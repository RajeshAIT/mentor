<?php

namespace App\Repositories;

use DB;
use FFMpeg;
use App\Models\Post;
use App\Models\Company;
use App\Models\Postmedia;
use App\Models\RankingList;
use App\Interfaces\PostInterface;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use Storage;

use App\Traits\FirebaseAPI;

class PostRepository implements PostInterface
{

    use FirebaseAPI;

    public function requestPost(PostRequest $request)
    {
        DB::beginTransaction();

        $badge = null;
        $post_count = 0;

        $user_id = Auth::user()->id;
        $company = Company::where('user_id','=',$user_id)->select('id')->first();

        if($company)
        {
        $post = new Post();

        $post->title=$request->title;
        $post->comment=$request->comment;
        $post->posted_by_id = Auth::user()->id;
        $post->company_id = $company->id;

        if(request()->post_type_id==1)
        {
            if($request->file('media_url')){
                $file_type = $request->file('media_url')->extension();

                if($file_type == 'mp4' || $file_type == 'flv' || $file_type == 'm3u8' || $file_type == 'ts' || $file_type == '3gp' || $file_type == 'mov' || $file_type == 'avi' || $file_type == 'wmv' || $file_type == '3gpp' || $file_type == 'mkv')
                {
                    $file = $request->file('media_url');
                    $ffmpeg = FFMpeg\FFMpeg::create([
                        'ffmpeg.binaries'  => 'C:/ffmpeg/bin/ffmpeg.exe',
                        'ffprobe.binaries' => 'C:/ffmpeg/bin/ffprobe.exe'
                    /*  'ffmpeg.binaries' => '/usr/bin/ffmpeg',
                        'ffprobe.binaries' => '/usr/bin/ffprobe'  */
                    ]);
                    $url_path = '/storage/public/post_media/thumbnail'.'/';
                    $storage_path = storage_path('public/post_media/thumbnail/');
                
                    $randomNumber = random_int(100000000, 999999999);
                    
                    $file_path = $storage_path."s".$randomNumber.".jpg";
                    $video = $ffmpeg->open($file);
                    $frame = $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(5))->save($file_path);
                    $new_file_url = $url_path.'s'.$randomNumber.'.jpg';
                    $media_thumbnail = 's'.$randomNumber.'.jpg';
            
                    $input['media_url'] = time() . '.' . $file->getClientOriginalExtension();
                    $uploaded_path = Storage::disk('s3')->put("post_media/".$input['media_url'],fopen($file,'r+'),'public');
                    $uploaded_file_type = '2';

                    $media_thumbnail_path = Storage::disk('s3')->put("post_media/thumbnail/".$media_thumbnail,file_get_contents($file_path),'public');
                    $file_url['url'] = $input['media_url'];

                } elseif($file_type == "jpeg" || $file_type == "png" || $file_type == "jpg" || $file_type == "webp")
                {
                    $file = $request->file('media_url');
                    $input['media_url'] = time() . '.' . $file->getClientOriginalExtension();
                    $uploaded_path = Storage::disk('s3')->put("post_media/".$input['media_url'],fopen($file,'r+'),'public');
                    $uploaded_file_type = '1';
                    $file_url['url'] = $input['media_url'];

                    $media_thumbnail_path = Storage::disk('s3')->put("post_media/thumbnail/".$input['media_url'],fopen($file,'r+'),'public');
                    $media_thumbnail = $input['media_url'];

                } elseif($file_type == "mpeg" || $file_type == "aac" || $file_type == "3gpp" || $file_type == "m4a" || $file_type == "amr" || $file_type == "mp3")
                {
                    $file = $request->file('media_url');
                    $url_path = 'public/post_media/thumbnail/';
                    $new_file_url = $url_path.'audio.jpg';

                    $input['media_url'] = time() . '.' . $file->getClientOriginalExtension();
                    $uploaded_path = Storage::disk('s3')->put("post_media/".$input['media_url'],fopen($file,'r+'),'public');
                    $uploaded_file_type = '3';

                    $file_url['url'] = $input['media_url'];

                    $media_thumbnail_path = Storage::disk('s3')->put("post_media/thumbnail/audio.jpg",file_get_contents(storage_path($new_file_url)),'public');
                    $media_thumbnail = 'audio.jpg';
                }
            }
            
            $post->post_type_id = 1;
            $post->save();

            if($post){
                $points = RankingList::create([
                    'user_id' => Auth::user()->id,
                    'points' => 5,
                    'reasons' => "Post",
                ]);

                $post_count = Post::where('posted_by_id','=',Auth::user()->id)->count();
                //$post_count = 100;
                if($post_count >= 25 && $post_count < 50){
                  $badge = "Silver";
                }elseif($post_count >= 50 && $post_count < 100  ){
                  $badge = "gold";
                }elseif($post_count >= 100){
                  $badge = "Platinum";
                }

            }
            
            $post_media = new Postmedia();
            $post_media->post_id = $post->id;
            $post_media->media_type_id = $uploaded_file_type;
            $post_media->media_url = $file_url['url'];
            $post_media->media_thumbnail = $media_thumbnail;
            $post_media->save();

            $s3 = Storage::disk('s3')->getAdapter()->getClient();
            $post_url = $s3->getObjectUrl( env('AWS_BUCKET'), 'post_media');

            $media = $post_url."/".$post_media->media_url;


            DB::commit();
            $responseData['status']=true;
            $responseData['message']='Post Created Successfully';
            $responseData['badge']= $badge;
            $responseData["post_count"] = $post_count;
            $postCollection = array("id" => $post['id'], "title" => $post['title'], "comment" => $post['comment'], "media_url" => $media);
            $responseData['data']=$postCollection;
            return response()->json($responseData);
        }

        if(request()->post_type_id==2)
        {
            $post->post_type_id = 2;
            $post->qualification=$request->qualification;
            $post->experience=$request->experience;
            $post->salary_min=$request->salary_min;
            $post->salary_max=$request->salary_max;
            $post->save();

            if($post){
                $points = RankingList::create([
                    'user_id' => Auth::user()->id,
                    'points' => 5,
                    'reasons' => "Job_Post",
                ]);
            }

            DB::commit();
            $responseData['status']=true;
            $responseData['message']='Job Post Created Successfully';
            $postCollection = array("id" => $post['id'], "title" => $post['title'], "comment" => $post['comment'], "qualification" => $post['qualification'], "experience" => $post['experience'], "salary_min" => $post['salary_min'], "salary_max" => $post['salary_max']);
            $responseData['data']=$postCollection;
            return response()->json($responseData);
        }
      } else {
            $responseData['status']=true;
            $responseData['message']='Invalid Company ID';
            return response()->json($responseData);
      }
    }

    public function getPost($id, $post_type_id)
    {
      if($post_type_id == '1')
      {
        $post_media = Postmedia::where('post_id', '=', $id)->select('media_type_id','media_url','media_thumbnail')->first();

       $postCollection=Post::where([['id', '=', $id],['post_type_id', '=', '1']])->select('title','comment','posted_by_id','company_id', 'created_at')->first();
       if($postCollection)
       {
       $postDetails['id']=$id;
       $postDetails['title']=$postCollection->title;
       $postDetails['comment']=$postCollection->comment;
       $postDetails['posted_by_id']=$postCollection->posted_by_id;
       $postDetails['company_id']=$postCollection->company_id;

       $s3 = Storage::disk('s3')->getAdapter()->getClient();
       $post_url = $s3->getObjectUrl( env('AWS_BUCKET'), 'post_media');
       $thumbnail_url = $s3->getObjectUrl( env('AWS_BUCKET'), 'post_media/');
       

       $postDetails['media']= $post_url."/".$post_media->media_url;
       $postDetails['thumbnail']= $thumbnail_url."thumbnail/".$post_media->media_thumbnail;
       if($post_media->media_type_id!=1)
       {
            $postDetails['thumbnail']= $thumbnail_url."thumbnail/".$post_media->media_thumbnail; 
       }
       $postDetails['media_type_id']=$post_media->media_type_id;
       $postDetails['date_time']=$postCollection->created_at;

        $responseData['status']=true;
        $responseData['message']='Successful';
        $responseData['data']=$postDetails;
        return response()->json($responseData);
       } else {
        $responseData['status']=false;
        $responseData['message']='Invalid ID';
        return response()->json($responseData);
       }
      } else {
        $postMediaCollection=Post::where([['id', '=', $id],['post_type_id', '=', '2']])->select('title','comment','posted_by_id','company_id', 'qualification', 'experience', 'salary_min', 'salary_max', 'created_at')->first();
        if($postMediaCollection)
        {
        $postDetails['id']=$id;
        $postDetails['title']=$postMediaCollection->title;
        $postDetails['comment']=$postMediaCollection->comment;
        $postDetails['posted_by_id']=$postMediaCollection->posted_by_id;
        $postDetails['company_id']=$postMediaCollection->company_id;
        $postDetails['qualification']=$postMediaCollection->qualification;
        $postDetails['experience']=$postMediaCollection->experience;
        $postDetails['salary_min']=$postMediaCollection->salary_min;
        $postDetails['salary_max']=$postMediaCollection->salary_max;
        $postDetails['date_time']=$postMediaCollection->created_at;

        $responseData['status']=true;
        $responseData['message']='Successful';
        $responseData['data']=$postDetails;
        return response()->json($responseData);
       } else 
       {
        $responseData['status']=false;
        $responseData['message']='Invalid ID';
        return response()->json($responseData);
       }
      }
    }
}