
@extends('layouts.layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
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
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$total_mentor}}</h3>
                <p>Total No.of Mentors</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="/mentor" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{$total_post}}</h3>

                <p>Total No.of Posts</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="/user/post" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          
          <!-- ./col -->
          <div class="col-lg-3 col-6">
           <div class="small-box bg-primary">
              <div class="inner">
                <h3>{{$total_mentee}}</h3>
                <p>Total No.of Mentees</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>	
              </div>
              <a href="/mentee" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
            <!-- small box -->
            <div class="small-box bg-orange">
              <div class="inner">
                <h3>{{$total_job}}</h3>

                <p>Total No.of JobPosts</p>
              </div>
              <div class="icon">
                <i class="ion ion-briefcase"></i>
              </div>
              <a href="/postmanagement" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{$total_question}}</h3>

                <p>Total No.of Questions</p>
              </div>
              <div class="icon">
                <i class="ion ion-chatboxes"></i>
              </div>
              <a href="/ask-question" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
             <!-- small box -->
             <div class="small-box bg-lime">
              <div class="inner">
                <h3>{{$total_company}}</h3>

                <p>Total No.of Companies</p>
              </div>
              <div class="icon">
                <i class="ion ion-ribbon-a"></i>
              </div>
              <a href="/company" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
            
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3> {{$total_answer}} </h3>

                <p>Total No.of Answers</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
             
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>


    <h1>Users Bar Chart</h1>
    <tr>
      <select id="chartType">
      <option value="thisweek"  @if($date_filter == "thisweek") ?: selected   @endif  >This Week</option>
      <option value="lastweek"  @if($date_filter == "lastweek") ?: selected  @endif>Last Week</option>

      <option value="thismonth"  @if($date_filter == "thismonth") ?: selected   @endif  >This Month</option>
      <option value="lastmonth"  @if($date_filter == "lastmonth") ?: selected  @endif>Last Month</option>
      </select>
    </tr>
    
    <div id="barchart_material" class="container" style="height: 500px;"></div>


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Users Report</h3>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
                 
                <table id="example1"  class="table table-bordered table-striped">
                  <thead>
                      <tr>
                            <th>Name</th>    
                            <th>Email</th>   
                            <th>Role Name</th>
                      </tr>
                  </thead>
    <tbody>
        @foreach($dashboard as $users)
    <tr>
        <td>{{$users->firstname}} {{$users->lastname}}</td>
        <td>{{$users->email}}</td>
        <td> 
            @if ($users->userrole_id == 1)
                <p>Mentor</p>
            @else
                <p>Mentee</p>
            @endif
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
  <!-- /.content-wrapper -->
<!-- Page specific script -->

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,"sorting": false,
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

<script type="text/javascript" src="{{asset('dist/js/barchart.js')}}"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);
  
      function drawChart() {
        var data = google.visualization.arrayToDataTable({{ Illuminate\Support\Js::from($result) }});
   
        var options = {
          chart: {
            title: 'Users Website Performance',
            subtitle: 'Mentor and Mentees',
          },
        };
  
        var chart = new google.charts.Bar(document.getElementById('barchart_material'));
  
        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>


    <script>

      $(document).ready(function(){
    $("#chartType").change(function(event){
        event.preventDefault();
        var barchart = $("#chartType").val();
        // alert(barchart);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

          $.ajax({
              url: '/chartfilter',
              data: {barchart : barchart},
              dataType : 'json',
              type: 'POST',
              success : function(data){
// alert(data);

                  location.reload();
                  
              }
          });
    });
    });
    </script>
   
  @endsection