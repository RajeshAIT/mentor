@extends('layouts.layout')
@section('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdn.jsdelivr.net/npm/@tinymce/tinymce-jquery@1/dist/tinymce-jquery.min.js"></script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Content Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Content Page</li>
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
                <h3 class="card-title"> Add Content Page </small></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="{{ route('content_page') }}"  enctype="multipart/form-data">
              @csrf <br>
                @if(session()->has('success'))
                  <div class="alert alert-success col-md-6">
                    {{ session()->get('success') }}
                  </div>
                @endif
                @if(session()->has('failed'))
                  <div class="alert alert-danger col-md-6">
                    {{ session()->get('failed') }}
                  </div>
                @endif
            

                  <div class="card-body">

                    <div class="form-group col-md-6">
                      <label for="page_title">Page Title</label>
                      <input type="hidden" name="mode" value="@if(@$content_pages->id)Edit @else New @endif" />
                      <input type="hidden" name="id" value="@if(@$content_pages->id) {{$content_pages->id}} @endif" />
                      <input type="text" name="page_title" class="form-control @error('page_title') is-invalid @enderror" id="page_title" value="@if(@$content_pages->page_title) {{$content_pages->page_title}} @else{{old('page_title')  }}@endif" placeholder="Enter Page Title" maxlength="50" autofocus>
                      @if($errors->has('page_title'))
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('page_title') }}</strong>
                            </span>
                      @endif
                    </div>

                    <div class="form-group col-md-6">
                      <label for="url_title">URL</label>
                      <input type="text" name="url_title" class="form-control @error('url_title') is-invalid @enderror" id="url_title" value="@if(@$content_pages->url_title) {{$content_pages->url_title}} @else{{old('url_title')  }}@endif" maxlength="50" placeholder="Enter URL" >
                      @if($errors->has('url_title'))
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('url_title') }}</strong>
                            </span>
                      @endif
                    </div>
                  
                    <div class="form-group">
                      <label for="content">Content</label>
                      <textarea id="summernote" class="@error('content') is-invalid @enderror" name="content" style='height:350px;'>@if(@$content_pages->content) {{$content_pages->content}} @else{{old('content')  }}@endif</textarea>
                      @if($errors->has('content'))
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('content') }}</strong>
                            </span>
                      @endif
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

  <script>
    $('document').ready(function(){
      $('textarea#summernote').tinymce({
        height: 300,
        menubar: false,
        plugins: [
           'a11ychecker','advlist','advcode','advtable','autolink','checklist','export',
           'lists','link','image','charmap','preview','anchor','searchreplace','visualblocks',
           'powerpaste','fullscreen','formatpainter','insertdatetime','media','table','help','wordcount'
        ],
        toolbar: 'undo redo | a11ycheck casechange blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist checklist outdent indent | removeformat | code table help'
      });
   
      $("#page_title").keyup(function(){
        var title = $(this).val();
        title     = title.replace(/ /g, "-");
        title     = title.toLowerCase();
        
        $("#url_title").val(title);
      });

      $("#url_title").keyup(function(){
        var title = $(this).val();
        title     = title.replace(/ /g, "-");
        title     = title.toLowerCase();
        
        $("#url_title").val(title);
      });
    });
  </script>
  
  @endsection