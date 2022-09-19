<?php

namespace App\Interfaces;

use App\Http\Requests\UserRequest;
// Admin Profile request
use App\Http\Requests\AdminRequest;

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

  public function create($request);

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

  //video report module
  public function videoReport();
  public function videoDelete($id);
  //video report module

  //post report module
  public function postReport();
  public function postDelete($id);
  //post report module

  //invalid email
  public function invalidEmail();
  //invalid email

  //video url
  public function videoURL($id);
  public function getMedia($id);
  //video url


  // Admin Profile Update
  public function userprofileedit($id);

  public function requestUserprofile(AdminRequest $request, $id);

  // Company Report
  // public function companyReport();
  // public function companyDelete($id);
  
}