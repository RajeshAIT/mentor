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
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Mentor</li>
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
                <h3 class="card-title"> Edit User</small></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="{{ route('users.update', $user->id) }}">
              @csrf
              @method('PATCH')

              <div class="col-md-6">
                <div class="card-body">
                  <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" name="firstname" class="form-control" id="firstname" placeholder="Enter First Name" required autofocus>
                  </div>
                  <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Last Name" required>
                  </div>
                  <div class="form-group">
                    <label for="Email_ID">Email-ID</label>
                    <input type="text" name="email" class="form-control" id="email" placeholder="Email" required>
                  </div>
                  <div class="form-group">
                    <label for="phonenumber">Phone Number</label>
                    <input type="text" name="phonenumber" class="form-control" id="phonenumber" placeholder="Phone Number" required>
                  </div>
                  <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="New Password" >
                  </div>
                  <div class="form-group">
                    <label for="password">Confirm Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Confirm Password">
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