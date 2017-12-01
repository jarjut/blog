@extends('adminlte::page')

@section('title', 'Settings')

@section('content_header')
    <h1>Settings</h1>
@endsection

@section('content')
  @if (session('status'))
    <div class="callout callout-success" role="callout">
      {{session('status')}}
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

  <form class="" action="{{route('options')}}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{-- Site --}}
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Site</h3>
      </div>
      <div class="box-body">
        <div class="form-group">
          <label for="">Title</label>
          <input type="text" name="title" class="form-control" value="{{$title}}" required>
        </div>
        <div class="form-group">
          <label for="">Logo Text <span style="font-weight:100;">(Max 8 character)</span></label>
          <input type="text" name="logo" class="form-control" value="{{$logo}}" maxlength="8" required>
        </div>
        <div class="form-group">
          <label for="">Description</label>
          <input type="text" name="description" class="form-control" value="{{$description}}" required>
        </div>
      </div>
    </div>
    {{-- Site --}}

    {{-- Banner --}}
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Banner</h3>
      </div>
      <div class="box-body">
        <div class="form-group">
          <label for="">Title</label>
          <input type="text" name="banner_title" class="form-control" value="{{$banner_title}}">
        </div>
        <div class="form-group">
          <label for="">Sub Title</label>
          <input type="text" name="banner_sub_title" class="form-control" value="{{$banner_sub_title}}">
        </div>
        <div class="form-group">
          <label for="">Image</label>
          <input type="file" name="banner_image" class="form-control" id="cropper">
        </div>
      </div>
    </div>
    {{-- Banner --}}

    {{-- Color Theme --}}
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Color Theme</h3>
      </div>
      <div class="box-body">
        <div class="form-group">
          <select class="form-control" id="sel1" name="colortheme">
            @foreach ($colors as $color)
            <option value="{{$color->id}}"  {{$color->id==$color_theme ? 'selected' : '' }}>{{$color->name}}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>
    {{-- Color Theme --}}
    <button type="submit" class="btn btn-primary">Save Changes</button>
  </form>
@endsection

@section('css')
  <link  href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.1.3/cropper.min.css" rel="stylesheet">
  <style media="screen">
    img {
      max-width: 100%;
    }
  </style>
@endsection

@section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.1.3/cropper.min.js"></script>
  <script type="text/javascript">
    $('form').preventDoubleSubmission();
  </script>
@endsection
