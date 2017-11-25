@extends('adminlte::page')

@section('title', 'Edit Comment')

@section('content_header')
    <h1>Edit Comment</h1>
@endsection

@section('content')
  @if (session('status'))
    <div class="callout callout-success" role="callout">
      {{session('status')}}
    </div>
  @endif
    <div class="row">
      <form class="" action="{{route('editcomment', ['id' => $comment->comment_id])}}" method="post">
        {{ csrf_field() }}
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Author</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <label for="">Name</label>
                <input type="text" name="name" class="form-control" value="{{$comment->author_name}}">
              </div>
              <div class="form-group">
                <label for="">Email</label>
                <input type="text" name="email" class="form-control" value="{{$comment->author_email}}">
              </div>
              <div class="form-group">
                <label for="">URL</label>
                <input type="text" name="url" class="form-control" value="{{$comment->author_url}}">
              </div>
            </div>
          </div>

          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Comment</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <textarea class="form-control" rows="5" name="content">{{$comment->content}}</textarea>
              </div>
            </div>
          </div>

        </div>
        <div class="col-md-3">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Action</h3>
            </div>
            <div class="box-body">
              <a href="{{route('viewpost',['post'=>$comment->post->post_id])}}#c{{$comment->comment_id}}">View Comment</a>
              <br>
              <br>
              <button type="submit" class="btn btn-primary">Update</button>
              </form>
              <form class="" action="{{route('editcomment', ['id' => $comment->comment_id])}}" method="post" style="margin-top:8px;">
                <input type="hidden" name="_method" value="DELETE">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </div>
          </div>
        </div>
    </div>
@endsection

@section('css')

@endsection

@section('js')

@endsection
