@extends('layouts.layout')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Mentor</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
              <li class="breadcrumb-item active">User</li>
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
                <h3 class="card-title"> Create new User </small></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="{{ route('store') }}" enctype="multipart/form-data">
              @csrf <br>
              @if(session()->has('message'))
                     <div class="alert alert-success">
                        {{ session()->get('message') }}
                     </div>
                @endif
                @if($errors->any())
                    {!! implode('', $errors->all('<div>:message</div>')) !!}
                @endif
              <div class="col-md-6">
                <div class="card-body">
                  <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" name="firstname" class="form-control" id="firstname" placeholder="Enter First Name" required autofocus>
                    @if($errors->has('firstname'))
                       <div class="error">{{ $errors->first('firstname') }}</div>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Last Name" required>
                    @if($errors->has('lastname'))
                        <div class="error">{{ $errors->first('lastname') }}</div>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="Email_ID">Email-ID</label>
                    <input type="text" name="email" class="form-control" id="email" placeholder="Email-ID" required>
                    @if($errors->has('email'))
                        <div class="error">{{ $errors->first('email') }}</div>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" required autocomplete="current-password">
                    @error('password')
                         <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                               </span>
                     @enderror
                  </div>
                  <div class="form-group">
                    <label for="password">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password" placeholder="Password" required autocomplete="current-password">
                    @if($errors->has('confirm_password'))
                        <div class="error">{{ $errors->first('confirm_password') }}</div>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="phonenumber">Phone Number</label>
                    <input type="text" name="phonenumber" class="form-control" id="phonenumber" placeholder="Phone Number"/>
                    @if($errors->has('phonenumber'))
                        <div class="error">{{ $errors->first('phonenumber') }}</div>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="userrole_id">Userrole ID</label>
                        <input type="text" name="userrole_id" class="form-control" id="userrole_id" placeholder="Userrole ID" required>
                        @if($errors->has('userrole_id'))
                            <div class="error">{{ $errors->first('userrole_id') }}</div>
                        @endif
                  </div>
                  <div class="form-group">
                    <label for="file" >Photo</label>
                        <input type="file" name="photo" class="form-control" id="photo" placeholder="Photo" required>
                        @if($errors->has('photo'))
                            <div class="error">{{ $errors->first('photo') }}</div>
                        @endif
                  </div>
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Title" required>
                    @if($errors->has('title'))
                       <div class="error">{{ $errors->first('title') }}</div>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="about">About</label>
                    <input type="text" name="about" class="form-control" id="about" placeholder="About" required>
                    @if($errors->has('about'))
                        <div class="error">{{ $errors->first('about') }}</div>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="experience">Experience</label>
                    <input type="text" name="experience" class="form-control" id="experience" placeholder="Experience" required>
                    @if($errors->has('experience'))
                        <div class="error">{{ $errors->first('experience') }}</div>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" name="location" class="form-control" id="location" placeholder="Location" required>
                    @if($errors->has('location'))
                        <div class="error">{{ $errors->first('location') }}</div>
                    @endif
                  </div>
                </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
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
  
  @endsection