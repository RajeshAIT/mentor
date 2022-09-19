@extends('layouts.layout')
   
@section('content')
<div class="content-wrapper">
    <div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Post</h2>
            </div>
            <div class="pull-left">
                <a class="btn btn-primary" href="{{ route('postmanagement.index') }}"> Back</a>
            </div>
        </div>
    </div><br>
   
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
  
    <form action="{{ route('post.update',$post->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
  
     <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <strong>Title</strong>
                <input type="text" name="title" class="form-control" value ="{{$post->title}}" >
            </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
                <strong>Comment</strong>
                <input type="text" name="comment" class="form-control" value ="{{$post->comment}}" >
            </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
                <strong>Qualification</strong>
                <input type="text" name="qualification" class="form-control" value ="{{$post->qualification}}" >
            </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
                <strong>Experience</strong>
                <input type="text" name="experience" class="form-control" value ="{{$post->experience}}" >
            </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
                <strong>Salary min</strong>
                <input type="text" name="salary_min" class="form-control" value ="{{$post->salary_min}}" >
            </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
                <strong>Salary max</strong>
                <input type="text" name="salary_max" class="form-control" value ="{{$post->salary_max}}" >
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