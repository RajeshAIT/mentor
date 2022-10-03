<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Interfaces\UserInterface;

use App\Http\Requests\UserRequest;
// Admin Profile request
use App\Http\Requests\AdminRequest;

use App\Http\Controllers\Controller;
use App\Http\Requests\FollowRequest;

class UserController extends Controller
{
    protected $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    public function register(Request $request)
    {
        return $this->userInterface->register($request);
    }

    public function login(Request $request)
    {
        return $this->userInterface->login($request);
    }

    public function createpassword(Request $request)
    {
        return $this->userInterface->createpassword($request);
    }

    public function ProfileResponse(Request $request)
   {
       return $this->userInterface->ProfileResponse($request);
   }

    public function show($id)
    {
        return $this->userInterface->show($id);
    }

    public function changepassword(Request $request)
    {
        return $this->userInterface->changepassword($request);
    }

    public function logout()
   {
        return $this->userInterface->logout();
   }

    public function dashboard()
    {
        return $this->userInterface->dashboard();
    }

    public function create(Request $request)
    {
        return $this->userInterface->create($request);
    }

    public function store(UserRequest $request)
    {
        return $this->userInterface->storeUser($request);
    }

    public function mentor(Request $request)
    {
        return $this->userInterface->getMentor($request);
    }

    public function mentee()
    {
        return $this->userInterface->getMentee();
    }

    public function edit($id)
    {
        return $this->userInterface->edit($id);
    }

    public function update(UserRequest $request, $id)
    {
        return $this->userInterface->requestUser($request, $id);
    }

    public function destroy($id)
    {
        return $this->userInterface->deleteUser($id);
    }

    public function forgotpassword($token)
    {
        return $this->userInterface->forgotpassword($token);
    }

    public function resetpassword(Request $request)
    {
        return $this->userInterface->resetpassword($request);
    }

    public function updatepassword(Request $request)
    {
        return $this->userInterface->updatepassword($request);
    }

    public function follow(FollowRequest $request)
    {
        return $this->userInterface->follow($request);
    }

    public function getfollow()
    {
        return $this->userInterface->getfollow();
    }

    public function getunfollow()
    {
        return $this->userInterface->getunfollow();
    }
    //video report module
    public function videoReport()
    {
        return $this->userInterface->videoReport();
    }
    public function videoDelete($id)
    {
        return $this->userInterface->videoDelete($id);
    }
    //video report module
    //audio report module
    public function postReport()
    {
        return $this->userInterface->postReport();
    }
    public function postDelete($id)
    {
        return $this->userInterface->postDelete($id);
    }
    //audio report module

    //invalid email
    public function invalidEmail(){
        return $this->userInterface->invalidEmail();
    }
    //invalid email

    //video url
    public function videoURL($id){
        return $this->userInterface->videoURL($id);
    }
    public function getMedia($id){
        return $this->userInterface->getMedia($id);
    }
    //video url


    //Admin profile dashboard
    
     public function userprofileedit($id)
     {
         return $this->userInterface->userprofileedit($id);
     }
     
     public function updateprofile(AdminRequest $request, $id)
     {
         return $this->userInterface->requestUserprofile($request, $id);
     }
 
    public function mentorTagList(Request $request){
        return $this->userInterface->mentorTagList($request);
    }
    
    //bar-chart dashboard page
    public function chartFilter(Request $request)
    {
        return $this->userInterface->chartFilter($request);
    }

   

   
}