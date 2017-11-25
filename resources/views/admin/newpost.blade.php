@extends('adminlte::page')

@section('title', 'Add New Post')

@section('content_header')
    <h1>Add New Post</h1>
@endsection

@section('content')
    <div class="row">
      <form class="" action="{{route('newpost')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="col-md-9">
          <div class="row">
            <div class="col-md-8">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Title</h3>
                </div>
                <div class="box-body">
                  <input type="text" name="title" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Image</h3>
                </div>
                <div class="box-body">
                  <label class="custom-file">
                    <input type="file" id="image" class="custom-file-input" name="image">
                    <span class="custom-file-control"></span>
                  </label>
                </div>
              </div>
            </div>
          </div>

          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Description</h3>
            </div>
            <div class="box-body">
              <input type="text" name="description" class="form-control" required>
            </div>
          </div>
          {{-- Content --}}

          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Content</h3>
            </div>
            <div class="box-body">
              <textarea id="content" name="content"></textarea>
            </div>
          </div>
          {{-- Content --}}
        </div>
        <div class="col-md-3">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Publish</h3>
            </div>
            <div class="box-body">
              <div class="form-check form-check-inline" style="margin-bottom:8px">
                <label class="form-check-label">
                  <input class="form-check-input" type="checkbox" name="headline" value="1"> Headline Post
                </label>
              </div>
              <button type="submit" class="btn btn-primary">Publish</button>
            </div>
          </div>
          {{-- Categories --}}
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Categories</h3>
            </div>
            <div class="box-body">
              @foreach ($categories as $category)
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="categories[]" value="{{$category->category_id}}">
                    {{$category->name}}
                  </label>
                </div>
              @endforeach
              <a href="{{route('categories')}}">Add New Category</a>
            </div>
          </div>
          {{-- Categories --}}
        </div>
      </form>
    </div>
@endsection

@section('css')

@endsection

@section('js')
  <script type="text/javascript" src="{{asset('vendor/ckeditor/ckeditor.js')}}"></script>
  <script type="text/javascript">
  $(function () {
    CKEDITOR.replace('content')
  })
  </script>
@endsection
