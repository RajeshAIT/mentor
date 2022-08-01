@extends('layouts.layout')
  
@section('content')
<div class = "content-wrapper">
<div class="container">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New Post</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('user.post') }}"> Back</a>
        </div><br>
    </div>
</div>
   
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
   
<form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
  
     <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <strong>Title</strong>
                <input type="text" name="title" class="form-control" >
            </div>
        </div>
        <div class="col-md-12">
        <div class="form-group">
                <strong>Comment</strong>
                <input type="text" name="comment" class="form-control" >
            </div>
        </div>
        <div class="col-md-12">
        <div class="form-group">
                <strong>Media</strong>
                <input type="file" name="media" class="form-control" >
            </div>
        </div>
        
        <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
   
</form>
</div>
</div>
@endsection