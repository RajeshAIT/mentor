<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Interfaces\UserInterface;

use App\Http\Requests\UserRequest;
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

    public function create()
    {
        return $this->userInterface->create();
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
}