@extends('layouts.layout')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        <div class="image">
          <img src="{{ asset ('/../dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        
          <div class="col-sm-8">
            <h1 style="text-align: center;">Admin Profile</h1>
          </div>
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Admin Profile</li>
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
          @if(session()->has('message'))
                     <div class="alert alert-success">
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                        {{ session()->get('message') }}
                     </div>
                @endif
                @if (session()->has('danger'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                         {{ session()->get('danger') }}
                     </div>
                   @endif
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"> Edit Profile </small></h3>
              </div>
             
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{ route('updateprofile', $user_details->id) }}" enctype="multipart/form-data">
              @csrf
              <!-- @method('PATCH')<br> -->

              @foreach($userlist as $user_session)
              <div class="col-md-6">
                <div class="card-body">
                  <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" name="firstname" class="form-control" id="firstname" placeholder="Enter First Name"   value="{{ $user_session->firstname }}"/>
                    @if($errors->has('firstname'))
                        <div class="error">{{ $errors->first('firstname') }}</div>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Last Name"  value="{{ $user_session->lastname }}"/>
                    @if($errors->has('lastname'))
                        <div class="error">{{ $errors->first('lastname') }}</div>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="Email_ID">Email-ID</label>
                    <input type="text" name="email" class="form-control" id="email" placeholder="Email"  value="{{ $user_session->email }}"/>
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
    <!-- /.content -->
  </div>
  
  @endsection