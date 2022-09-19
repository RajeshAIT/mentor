@extends('layouts.layout')
@section('content')

<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3 class="m-0">Mentor Report</h3>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
        <form action="{{ route('create_user')}}">
           <input type='hidden' name= 'user_role' value='Mentor' />
           <button class="btn btn-success btn-sm float-right">ADD NEW MENTOR</button>
        </form><br>
      </div><!-- /.container-fluid -->
    </div>
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
          <!-- <a href="{{ route('create_user')}}" class="btn btn-warning btn-sm">ADD</a> -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Mentor's List</h3>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
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
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Email-ID</td>
                    <td>Phone Number</td>
                    <td>Userrole ID</td>
                    <td>Photo</td>
                    <td>Title</td>
                    <td>About</td>
                    <td>Experience</td>
                    <td>Location</td>
                    <td>Action</td>
                  </tr>
                  </thead>
                  <tbody>
                  @if (is_array($userlist) || is_object($userlist))
                  @foreach($userlist as $users)
                 <tr>
                  <td>{{$users->id}}</td>
                  <td>{{$users->firstname}}</td>
                  <td>{{$users->email}}</td>
                  <td>{{$users->phonenumber}}</td>
                  <td>{{$users->userrole_id}}</td>
                  <td>{{$users->photo}}</td>
                  <td>{{$users->title}}</td>
                  <td>{{$users->about}}</td>
                  <td>{{$users->experience}}</td>
                  <td>{{$users->location}}</td>
                  <td>
                    <a href="{{ route('user_edit', $users->id)}}" class="btn btn-primary btn-xs"><i class='fas fa-edit'></i></a>
                    <form action="{{ route('delete', $users->id)}}" method="POST" style="display: inline-block">
                      @csrf
                      @method('DELETE')
                        <button class="btn btn-danger btn-xs btn-danger btn-flat show_confirm " title='Delete'> <i class="fa fa-trash"></i></button>
                    </form>
                  </td>
                </tr>
               @endforeach
             @endif
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
 </div>
 <!-- ./wrapper -->
</div>

<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script type="text/javascript">
 
     $('body').on('click','.show_confirm',function(event) {
      event.preventDefault();
      
          var form =  $(this).closest("form");
          var name = $(this).data("name");
          
          swal({
              title: `Are you sure you want to delete this record ?`,
              text: "If you delete this, it will be gone forever.",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              form.submit();
            }
          });
      });
  
</script>
@endsection