<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Post;

class PostManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::where('post_type_id',"2")->leftjoin('users','users.id', 'posts.posted_by_id')
        ->leftjoin('companies','companies.id','posts.company_id')
        ->leftjoin('posttypes','posttypes.id','posts.post_type_id')
        ->select('posts.*','companies.company_name','users.firstname','users.lastname','posttypes.type')
        ->get();
        return view('postmanagement.index',compact('posts'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $post = Post::find($id);
      $post->delete();
      return redirect()->back()->with('danger','Post deleted successfully');
    }
}
