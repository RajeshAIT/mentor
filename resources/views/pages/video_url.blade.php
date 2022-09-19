<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin</title>

  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset ('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset ('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset ('plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset ('dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset ('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset ('plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset ('plugins/summernote/summernote-bs4.min.css') }}">
</head>
<body >


  <div class="row" >
    <div class='col-md-12' style='text-align:center;padding-top:100px;'>
      <h2>Here is the Question and Answer</h2>
      
      <p>{{$answer->question}}</p>
      @if(strtoupper($media_type) == strtoupper('png') || $media_type == "jpg" || $media_type == "jpeg")
      <img src="{{ route('get_media',$answer->media) }}" class="rounded" alt="Cinque Terre" width="304" height="236">
      @elseif($media_type == "mp4" || $media_type == "ogg")
      <video width="320" height="240" controls>
        <source src="{{ route('get_media',$answer->media) }}" type="video/mp4">
        <source src="{{ route('get_media',$answer->media) }}" type="video/ogg">
      </video>
      @elseif($media_type == "mp3" || $media_type == "ogg")
      <audio controls>
        <source src="{{ route('get_media',$answer->media) }}" type="audio/ogg">
        <source src="{{ route('get_media',$answer->media) }}" type="audio/mpeg">
      </audio>
      @endif
    </div>
  </div>



</body>
</html>