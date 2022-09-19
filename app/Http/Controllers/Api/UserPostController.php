<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Post;

class UserPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $user_posts = Post::where('post_type_id',"1")->leftjoin('users','users.id', 'posts.posted_by_id')
       ->leftjoin('companies','companies.id','posts.company_id')
       ->leftjoin('posttypes','posttypes.id','posts.post_type_id')
       ->leftJoin('postmedia','postmedia.post_id','posts.id')
       ->select('posts.*','companies.company_name','users.firstname','users.lastname',
       'posttypes.type','postmedia.media_url')
       ->get();
       return view ('userpost.index',compact('user_posts'));
    }

    public function destroy($id)
    {
      $post = Post::find($id);
      $post->delete();
      return redirect()->back()->with('danger','Post deleted successfully');
    }
}