@extends('adminlte::page')

@section('title', 'Edit Post')

@section('content_header')
    <h1>Edit Post</h1>
@endsection

@section('content')
    @if (session('status'))
      <div class="callout callout-success" role="callout">
        {{session('status')}} | <a href="{{route('viewpost', ['post' => $post->post_id])}}">View Post</a>
      </div>
    @endif
    @if ($errors->any())
      <div class="callout callout-danger" role="callout">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
      </div>
    @endif
    <div class="row">
      <form class="" action="{{route('editpost', ['post' => $post->post_id])}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="col-md-9">
          <div class="row">
            <div class="col-md-8">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Title</h3>
                </div>
                <div class="box-body">
                  <input type="text" name="title" class="form-control" value="{{$post->title}}" required>
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
              <p><span style="font-weight:100; font-size:12px;">Should be more than 25 words</span></p>
              <input type="text" name="description" class="form-control" value="{{$post->description}}" required>
            </div>
          </div>

          {{-- Content --}}

          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Content</h3>
            </div>
            <div class="box-body">
              <textarea id="content" name="content" >{{$post->content}}</textarea>
            </div>
          </div>
          {{-- Content --}}
        </div>
        <div class="col-md-3">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Action</h3>
            </div>
            <div class="box-body">
              <a href="{{route('viewpost',['post'=>$post->post_id])}}">View Post</a>
              <br>
              <br>
              @if ($announcement)
                <input type="hidden" name="announcement" value="{{$announcement}}">
              @endif
              <button type="submit" class="btn btn-primary">Update</button>
            </form>
            <form class="" action="{{route('editpost', ['post' => $post->post_id])}}" method="post" style="margin-top:8px;">
              <input type="hidden" name="_method" value="DELETE">
              {{ csrf_field() }}
              <button type="submit" class="btn btn-danger">Delete</button>
            </form>
            </div>
          </div>
          {{-- Categories --}}
          @if (!$announcement)
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Categories</h3>
              </div>
              <div class="box-body">
                @php
                  function checkCategory($postcategories, $id){
                    foreach ($postcategories as $postcategory) {
                      if ($postcategory->category_id == $id) {
                        return true;
                      }
                    }
                    return false;
                  }
                @endphp
                @foreach ($categories as $category)
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="form-check-input" type="checkbox" name="categories[]" value="{{$category->category_id}}" {{checkCategory($post->categories, $category->category_id) ? 'checked' : ''}}>
                      {{$category->name}}
                    </label>
                  </div>
                @endforeach
                <a href="{{route('categories')}}">Add New Category</a>
              </div>
            </div>
          @endif
          {{-- Categories --}}
        </div>
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
