@extends('layouts.layout')
@section('content')

<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3 class="m-0">Video Report</h3>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
        
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
                <h3 class="card-title">Video Report's List</h3>
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
                    <td>Report By</td>
                    <td>Mentor Details</td>
                    <td>Report Content</td>
                    <td>Comments</td>
                    <td>Action</td>
                  </tr>
                  </thead>
                  <tbody>
                        @foreach($video_object as $value)
                        <tr>
                         <td>{{$value['id']}}</td>
                         <td>{{$value['report_by']}}<br/>{{$value['email']}}</td>
                         <td>{{$value['answer_by']}}<br/>{{$value['mentor_email']}}</td>
                         <td>{{$value['report_content']}}</td>
                         <td>{{$value['comments']}}</td>
                         <td>
                         <form action="{{ route('video_delete', $value['id'])}}" method="POST" style="display: inline-block">
                            @csrf
                            @method('DELETE')
                              <button class="btn btn-danger btn-xs btn-danger btn-flat show_confirm " title='Delete'> <i class="fa fa-trash"></i></button>
                          </form> 
                          </td>
                       </tr>
                       @endforeach
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
 
     $('.show_confirm').click(function(event) {
          var form =  $(this).closest("form");
          var name = $(this).data("name");
          event.preventDefault();
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