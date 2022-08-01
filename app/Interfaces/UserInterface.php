<?php

namespace App\Interfaces;

use App\Http\Requests\UserRequest;
use App\Http\Requests\FollowRequest;

interface UserInterface
{
  public function dashboard();

  public function register($request);

  public function login($request);

  public function createpassword($request);

  public function ProfileResponse($request);

  public function show($id);

  public function changepassword($request);

  public function logout();

  public function getMentor();

  public function getMentee();

  public function create();

  public function storeUser(UserRequest $request);

  public function edit($id);

  public function requestUser(UserRequest $request, $id);

  public function deleteUser($id);
  
  public function forgotpassword($token);

  public function updatepassword($request);

  public function resetpassword($request);

  public function follow(FollowRequest $request);
  
  public function getfollow();

  public function getunfollow();
}