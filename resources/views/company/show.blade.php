@extends('layouts.layout')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                    <h1 style="text-align: center;">Company Detail</h1>
            </div>
            <div class="col-sm-3">
                    @if ($user_posts->logo)
                            <img src="{{ route('companieslogo',$user_posts->id)}}" width = '150px' class="img-circle elevation-2" alt="{{$user_posts->title}}"/>
                    @else 
                            <img src="{{ asset('storage/logo/no image.jpg') }}" width = '200px' class="img-circle elevation-2"/>
                    @endif
            </div>
            <div class="col-sm-3" style="margin-top: 25px; font-weight: 500;">
                    <div class="col-12 col-md-8">
                        <span>{{ $user_posts->company_name }}</span>
                    </div>
                    <div class="col-12 col-md-8" style="margin-top: 30px;">
                        <span>{{ $user_posts->description }}</span>
                    </div>
            </div>
            
            <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Company Detail</li>
                    </ol>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    

   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
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
       <div class="row">
         <div class="col-12">
           <div class="card card-primary card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                      <li class="nav-item">
                          <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Company People</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Post</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">JobPost</a>
                      </li> 
                       <!-- <li class="nav-item">
                          <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Settings</a>
                      </li>  -->
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                          <div class="profile-content-right">
                                <div class="profile-detail-fields">
                                    <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                    <tr>
                                                        <th>Company People</th>
                                                        <th>Created Role</th>
                                                    </tr>
                                            </thead>
                                            <tbody>
                                                    @foreach($people as $companypeople)
                                                    <tr>
                                                        <td>{{$companypeople->name}}</td>
                                                        <td>{{$companypeople->userrole_id}}</td>
                                                        <!-- <td><img src="{{ asset('/../dist/img/' . $user_posts->logo) }}" width = '100px'/></td> -->
                                                    </tr>
                                                   @endforeach
                                            </tbody>
                                    </table>
                                </div>
                        </div>
             </div>
                          
         <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
           
            <section class="content">
                <div class="col-md-12">
                    <div class="card">
                       
                        <div class="card-body">
                            <div class="tab-content">
                                
                                  @foreach($posts as $post)
                                    <div class="post">
                                            <div class="user-block">
                                                    <span class="username">
                                                            <a href="#">{{$post->firstname}} {{$post->lastname}}  </a>
                                                            <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                                    </span>
                                                    <span class="description"><?= date("d-m-Y H:iA", strtotime($post->created_at)) ?></span>
                                            </div>
                                            <div>
                                                <p>{{$post->title}} {{$post->description}}</p>   
                                            </div>
                                    
                                    <div>
                                        <?php 
                                        $media_type_array = explode(".",$post->media_url) ;
                                        $media_extension = end($media_type_array);
                                        // dd($media_extension);
                                        ?>

                    @if ($media_extension == 'png' || $media_extension == "jpg" || $media_extension == "jpeg")
                            <img src="{{ route('postmediaImage',$post->post_id)}}" width = '150px' alt="No Image"/>
                    @elseif ($media_extension == "mp4" || $media_extension == "ogg")
                    <video width="320" height="240" controls>
                          <source src="{{ route('postmediaImage',$post->post_id) }}" type="video/mp4" alt="No Video">
                    </video>
                    @else ($media_extension == "mp3" || $media_extension == "ogg")
                    <audio controls>
                          <source src="{{ route('postmediaImage',$post->post_id) }}" type="audio/ogg" alt="No audio">
                    </audio>
                    @endif

                                    </div>
                                </div>
                                  @endforeach
                            </div>
                        </div>
                        
                </div>
            </section>
         </div>
                          <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                          <section class="content">
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-header p-2">
                                            <ul class="nav nav-pills">
                                                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                                            </ul>
                                    </div>

                                <div class="card-body">
                        @foreach($jobposts as $jobpost)

                                    <div class="tab-content">
                                    <div class="active tab-pane" id="activity">
                                    <div class="post">
                                    <div class="user-block">
                                        <!-- <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image"> -->
                                        <span class="username">
                                            <a href="#">{{$jobpost->firstname}} {{$jobpost->lastname}}  </a>
                                            <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                        </span>
                                        <span class="description"><?= date("d-m-Y H:iA", strtotime($jobpost->created_at)) ?></span>
                                    </div>
                                    <div>
                                        <p>Job: {{$jobpost->title}}</p>
                                    </div>
                                    <div>
                                        <p>Qualification: {{$jobpost->qualification}}</p>
                                    </div>
                                    <div>
                                        <p>Experience: {{$jobpost->experience}}</p>
                                    </div>
                                    <div>
                                        <p>Salary Min-Max: {{$jobpost->salary_min}} - {{$jobpost->salary_max}}</p>
                                    </div>
                                    
                                   
                @endforeach

</div>
 
</div>
</div>

</div>
</section>

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
    <!-- /.content -->
  </div>
</div> 
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
  @endsection
  