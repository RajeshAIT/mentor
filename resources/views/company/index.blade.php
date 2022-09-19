@extends('layouts.layout')
@section('content')

<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3 class="m-0">Company Management</h3>
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
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Company Detail</h3>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
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
                          <th>Id</th>
                          <th>Company Name</th>
                          <th>Created UserName</th>
                          <th>Action</th>
                      </tr>
              </thead>
            <tbody>
              @foreach($company_details as $post)
              <tr>
                <td>{{$companyindex++}}</td>
                <td>{{$post->company_name}}</td>
                <td>{{$post->firstname}} {{$post->lastname}}</td>
                <td>
                <form action="{{ route('companydestroy',$post->id) }}" method="GET">
                  @csrf
                  @method('DELETE')
                  <input name="_method" type="hidden" value="DELETE">
                  
                  <a href="{{ route('companyshow', $post->id)}}" class="btn btn-info btn-sm"data-toggle="tooltip" title='show'><i class='fas fa-eye'></i></a>
               
                  <button type="submit" class="btn btn-sm btn-danger btn-flat show_confirm" data-toggle="tooltip" title='Delete'><i class="fa fa-trash"></i></button>
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