@extends('adminlte::page')

@section('title', 'Add New Post')

@section('content_header')
    <h1>Add New Announcement</h1>
@endsection

@section('content')
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
      <form class="" action="{{route('newannouncement')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="col-md-9">
          <div class="row">
            <div class="col-md-8">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Title</h3>
                </div>
                <div class="box-body">
                  <input type="text" name="title" class="form-control" value="{{old('title')}}" required>
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
              <input type="text" name="description" class="form-control" value="{{old('description')}}" required>
            </div>
          </div>
          {{-- Content --}}

          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Content</h3>
            </div>
            <div class="box-body">
              <textarea id="content" name="content">{{old('content')}}</textarea>
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
              <button type="submit" class="btn btn-primary">Publish</button>
            </div>
          </div>
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
  });
  $('form').preventDoubleSubmission();
  </script>
@endsection
