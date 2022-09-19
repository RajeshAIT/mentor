@extends('layouts.layout')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
         @if($user->userrole_id == 1)
            <h1>Mentor</h1>
         @else
            <h1>Mentee</h1>
        @endif
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
              @if($user->userrole_id == 1)
              <li class="breadcrumb-item active">Mentor</li>
              @else
              <li class="breadcrumb-item active">Mentee</li>
              @endif
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

  <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"> Edit User </small></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{ route('update', $user->id) }}" enctype="multipart/form-data">
              @csrf
              @method('PATCH')<br>

              @foreach($userprofile as $user)
              <div class="col-md-6">
                <div class="card-body">
                  <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" name="firstname" class="form-control" id="firstname" placeholder="Enter First Name"   value="{{ $user->firstname }}"/>
                    @if($errors->has('firstname'))
                        <div class="error">{{ $errors->first('firstname') }}</div>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Last Name"  value="{{ $user->lastname }}"/>
                    @if($errors->has('lastname'))
                        <div class="error">{{ $errors->first('lastname') }}</div>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="Email_ID">Email-ID</label>
                    <input type="text" name="email" class="form-control" id="email" placeholder="Email"  value="{{ $user->email }}"/>
                    @if($errors->has('email'))
                        <div class="error">{{ $errors->first('email') }}</div>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control " id="password" placeholder="Password" required autocomplete="current-password">
                    @error('password')
                         <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                               </span>
                     @enderror
                  </div>
                  <div class="form-group">
                    <label for="password">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" required autocomplete="current-password">
                    @error('password')
                         <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                               </span>
                     @enderror 
                  </div>
                  <div class="form-group">
                    <label for="phonenumber">Phone Number</label>
                    <input type="text" name="phonenumber" class="form-control" id="phonenumber" placeholder="Phone Number" value="{{ $user->phonenumber }}"/>
                    @if($errors->has('phonenumber'))
                        <div class="error">{{ $errors->first('phonenumber') }}</div>
                    @endif
                  </div>

                  <div class="form-group">
                    
                    <label for="userrole_id">Userrole ID</label><br/>
                        <input type="radio" name="userrole_id" id="mentor1"   value="1" @if($user->userrole_id == '1' ) checked @endif required><label for="mentor1">Mentor</label><br/>
                        <input type="radio" name="userrole_id" id="mentee2"  value="2" @if($user->userrole_id == '2' ) checked @endif required><label for="mentee2">Mentee</label>
                        @if($errors->has('userrole_id'))
                            <div class="error">{{ $errors->first('userrole_id') }}</div>
                        @endif
                  </div>
                  <div class="form-group">
                    <label for="file" >Photo</label>
                    @if($user->photo)
                    <img id="photo" src="{{ url('/api/user/profile/images/'.$user->id) }}" alt="user-avatar" height="70" width="70">
                    @endif
                        <input type="file" name="photo" class="form-control" placeholder="" value="{{ $user->photo }}">
                        @if($errors->has('photo'))
                            <div class="error">{{ $errors->first('photo') }}</div>
                        @endif
                  </div>
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Title"  value="{{ $user->title }}">
                    @if($errors->has('title'))
                       <div class="error">{{ $errors->first('title') }}</div>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="about">About</label>
                    <input type="text" name="about" class="form-control" id="about" placeholder="About"  value="{{ $user->about }}">
                    @if($errors->has('about'))
                        <div class="error">{{ $errors->first('about') }}</div>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="experience">Experience</label>
                    <input type="text" name="experience" class="form-control" id="experience" placeholder="Experience"  value="{{ $user->experience }}">
                    @if($errors->has('experience'))
                        <div class="error">{{ $errors->first('experience') }}</div>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" name="location" class="form-control" id="location" placeholder="Location"  value="{{ $user->location }}">
                    @if($errors->has('location'))
                        <div class="error">{{ $errors->first('location') }}</div>
                    @endif
                  </div>
                  </div>
                </div>
                @endforeach
                <!-- /.card-body -->
                <div class="card-footer text-center">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          </div>
          
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <style>
    .error{
      color:red;
    }
  </style>

  @endsection