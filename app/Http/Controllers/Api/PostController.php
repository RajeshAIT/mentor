<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
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
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required|max:255',
            'comment' => 'required|max:255',
            'posted_by_id' => 'required',
            'company_id' => 'required',
            'post_type_id' => 'required',
            'image' => 'required',
            'video' => 'required',
            'document' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'error']);
        }
       
        $post = new Post();

        $post->title = $data['title'];
        $post->comment = $data['comment'];
        $post->posted_by_id = $data['posted_by_id'];
        $post->company_id = $data['company_id'];
        $post->post_type_id = $data['post_type_id'];
        $post->save();

      /*  $fetch = $request->all();
        $company = new Company();
        $company->name = $fetch['name'];
        $company->logo = $fetch['logo'];
        $company->description = $fetch['description'];
        $company = Company::whereid($data['company_id'])->get($fetch);
        $logo = url('/api/image/' . $data['company_id']);  */

      $responseData['status']=true;
      $postCollection = array("title" => $data['title'], "comment" => $data['comment'], "posted_by_id" => $data['posted_by_id'], "company_id" => $data['company_id'], "post_type_id" => $data['post_type_id']);
      $responseData['data']=$postCollection;
      return response()->json($responseData);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
