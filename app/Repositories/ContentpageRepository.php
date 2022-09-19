<?php

namespace App\Repositories;

use File;

use App\Models\User;
use App\Models\Contentpage;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\ContentpageInterface;
use Illuminate\Support\Facades\Validator;

class ContentpageRepository implements ContentpageInterface
{
  
    public function contentPageIndex(){

      $Contentpage = Contentpage::get();
        
      return view('pages.content_page_list',compact('Contentpage'));
    }

    public function contentPageAddIndex(){

        
      return view('pages.add_content_page');
    }
    
    public function addContentPage($request){

        $url = 'https://fcm.googleapis.com/fcm/send';
        
        $serverKey = 'AAAAdQvuZ5Y:APA91bE8-5Jhsc2zD9TcHiws5NNZ5o03uGW9E5J5ikMZ9iSu6_2g_GfSS3MMq2FAEZ_6fgBrWz7WsEsvqVaM9XQ_25Q6wr8zSoKkcB8hmFsM1WBXXUfaD6iwRu-xqWZdMMutIBt0a7w8';
        $FcmToken = User::whereNotNull('fcm')->pluck('fcm')->all();
        
        $data = [
            "registration_ids" => $FcmToken, 
            "notification" => [
                "title" => $request->page_title,
                "body" => 'Welcome to mentor App',
                "icon" => asset("assets/img/hero-img.png") 
            ]
        ];
        $encodedData = json_encode($data);
        
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

        // Execute post
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }        

        // Close connection
        curl_close($ch);
        
        $validatedData = $request->validate([
          'url_title' => 'required',
          'content' => 'required',
          'page_title' => 'required',
        ]);


        $content     = $request->content;
        $page_title  = $request->page_title;
        $url_title   = $request->url_title; 
        $mode        = $request->mode;
        $id          = $request->id;

        if($mode == "New"){
          $Contentpage = Contentpage::create([
            "page_title" => $page_title,
            "url_title" => $url_title,
            'content' => $content
          ]);
        }else{
          $edit_content_page = Contentpage::where("id",$id)->update(["page_title" => $page_title,"content" => $content,"url_title" => $url_title]);
        }

          if(@$Contentpage->id){
            return back()->with('success', 'Content Page Created Successfully');
          }elseif(@$edit_content_page){
            return back()->with('success', 'Content Page Updated Successfully');
          }else{
            return back()->with('failed', 'Content Page Created Failed');
          }

          

        

    }

    public function keywordSearch($request){
        
      
      return response()->json($responsedData);

    }

    public function viewContentPage($url_title){

      $content_pages = Contentpage::where("url_title",$url_title)->select("page_title","content")->first();

      return view("pages.content_page",compact('content_pages'));

    }

    public function contentPages(){

      $content_pages = Contentpage::select("url_title","page_title")->get();

      $content_page_array = array();
      $cnt = 0;

      foreach($content_pages as $contentpage){

        $url_title                              = $contentpage->url_title;
        $content_page_array[$cnt]["page_title"] = $contentpage->page_title; 
        $content_page_array[$cnt]["url"]        = asset("content/".$url_title); 
        $cnt++;
      }

      $responseData["content_pages"] = $content_page_array;

      return response()->json($responseData); 

    }

    public function contentPageDelete($id){

      $content_pages = Contentpage::where("id",$id)->delete();

      return back()->with("danger","Content Page Deleted Successfully");

    }

    public function contentPageEditIndex($id){

      $content_pages = Contentpage::where("id",$id)->first();
        
      return view('pages.add_content_page',compact('content_pages'));
    }
}