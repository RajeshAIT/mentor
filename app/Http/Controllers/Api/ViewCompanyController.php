<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\Company;
use App\Models\Postmedia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ViewCompanyController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
       $companyCollection=Company::where('id',$id)->select('user_id','name','logo','description')->first();
       $companyDetails['user_id']=$companyCollection->user_id;
       $companyDetails['name']=$companyCollection->name;
       $companyDetails['description']=$companyCollection->description;
       $companyDetails['logo']=url('/api/image/'.$id);

        $posts = Post::where('company_id',$id)->select('id','title','comment')->get();
        $userpostDetails=[];
        $uservideoDetails=[];
        foreach($posts as $userPost)
        {
            $postDetails['title']=$userPost->title;
            $postDetails['comment']=$userPost->comment;
            $postDetails['media']=url('/api/post/media/'.$userPost->id);
            array_push($userpostDetails,$postDetails);
            //Get user video
            $post_media = Postmedia::where([['post_id', '=', $userPost->id],['media_type_id', '=', '2']])->select('media_url')->first();
            if($post_media)
            {
            $videourl= url('/api/post/media/' . $userPost->id);
                            array_push($uservideoDetails,$videourl);
            }
        }

        $companyDetails['post']=$userpostDetails;
        $companyDetails['video']=$uservideoDetails;

        $responseData['status']=true;
        $responseData['data']=$companyDetails;
        return response()->json($responseData);
    }

    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($id)
    {
        //
    }
}
