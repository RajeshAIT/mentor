@extends('layouts.layout')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{$type}}</h1>
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
              <form method="post" action="{{ route('store') }}"  enctype="multipart/form-data">
              @csrf <br>
              @if(session()->has('message'))
                     <div class="alert alert-success">
                        {{ session()->get('message') }}
                     </div>
                @endif
                
              <div class="col-md-6">
                <div class="card-body">
                  <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" name="firstname" class="form-control @error('firstname') is-invalid @enderror" id="firstname" value="{{old('firstname')  }}" placeholder="Enter First Name" autofocus>
                    @if($errors->has('firstname'))
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('firstname') }}</strong>
                          </span>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="lastname" class="form-control @error('lastname') is-invalid @enderror" id="lastname" value="{{old('lastname')  }}" placeholder="Last Name" >
                    @if($errors->has('lastname'))
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('lastname') }}</strong>
                          </span>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="Email_ID">Email-ID</label>
                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')  }}" id="email" placeholder="Email-ID" >
                    @if($errors->has('email'))
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                          </span>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" value="{{old('password')  }}" autocomplete="current-password">
                    @if($errors->has('password'))  
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                          </span>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="password">Confirm Password</label>
                    <input type="password" name="password_confirmation" value="{{old('password_confirmation')  }}" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" autocomplete="current-password">
                    @error('password')
                         <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                     @enderror
                  </div>
                  <div class="form-group">
                    <label for="phonenumber">Phone Number</label>
                    <input type="text" name="phonenumber" class="form-control" value="{{old('phonenumber')  }}" id="phonenumber" placeholder="Phone Number"/>
                    @if($errors->has('phonenumber'))
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('phonenumber') }}</strong>
                          </span>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="userrole_id">Userrole ID</label><br/>
                        <input type="radio" name="userrole_id" id="mentor1" class="@error('userrole_id') is-invalid @enderror"  value="1" @if(old('userrole_id' ) == '1' ) checked @endif ><label for="mentor1">Mentor</label><br/>
                        <input type="radio" name="userrole_id" id="mentee2" class="@error('userrole_id') is-invalid @enderror"  value="2" @if(old('userrole_id' ) == '2' ) checked @endif ><label for="mentee2">Mentee</label>
                        @if($errors->has('userrole_id'))
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('userrole_id') }}</strong>
                          </span>
                        @endif
                  </div>
                  <div class="form-group">
                    <label for="file" >Photo</label>
                        <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" id="photo"  placeholder="Photo" >
                        @if($errors->has('photo'))
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('photo') }}</strong>
                          </span>
                        @endif
                  </div>
                  <div class="form-group">
                    <label for="title">Title</label> 
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{old('title')  }}" id="title" placeholder="Title" >
                    @if($errors->has('title'))
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('title') }}</strong>
                          </span>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="about">About</label>
                    <input type="text" name="about" class="form-control @error('about') is-invalid @enderror" value="{{old('about')  }}" id="about" placeholder="About" >
                    @if($errors->has('about'))
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('about') }}</strong>
                          </span>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="experience">Experience</label>
                    <input type="text" name="experience" class="form-control @error('experience') is-invalid @enderror" value="{{old('experience')  }}" id="experience" placeholder="Experience" >
                    @if($errors->has('experience'))
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('experience') }}</strong>
                          </span>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{old('location')  }}" id="location" placeholder="Location" >
                    @if($errors->has('location'))
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('location') }}</strong>
                          </span>
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