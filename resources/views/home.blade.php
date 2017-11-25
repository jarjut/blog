@extends('layouts.master')

@section('content')
  @if (isset($headline))
    <div class="content-grid">
      <div class="content-grid-head">
        <h3>HEADLINE</h3>
        <h4>{{$headline->created_at}},Posted by: <a href="#">{{$headline->user->username}}</a></h4>
        <div class="clearfix"></div>
      </div>
      <div class="content-grid-info">
      @if ($headline->image!=0)
        <div class="row">
          <div class="col-sm-4">
            @if ($headline->image!=0)
              <a href="{{url('post/'.$headline->post_id)}}">
                <img src="{{asset('storage/imagepost/'.$headline->post_id.'.jpg')}}" alt="" />
              </a>
            @endif
          </div>
          <div class="col-sm-8">
            <h3><a href="{{url('post/'.$headline->post_id)}}">{{$headline->title}}</a></h3>
            <p>{{$headline->description}}</p>

          </div>
        </div>
      @else
        <h3><a href="{{url('post/'.$headline->post_id)}}">{{$headline->title}}</a></h3>
        <p>{{$headline->description}}</p>
      @endif
        <a class="bttn" href="{{url('post/'.$headline->post_id)}}">READ MORE</a>
      </div>
    </div>
  @endif
  @foreach ($posts as $post)

    <div class="content-grid-sec">
      <div class="content-sec-info">
        <h3><a href="{{url('post/'.$post->post_id)}}">{{$post->title}}</a></h3>
        <h4>{{$post->created_at}}, Posted by : <a href="#">{{$post->user->username}}</a></h4>
        <p>{{$post->description}}</p>
        @if ($post->image!=0)
          <a href="{{url('post/'.$post->post_id)}}">
            <img src="{{asset('storage/imagepost/'.$post->post_id.'.jpg')}}" alt="" />
          </a>
        @endif
        <a class="bttn" href="{{url('post/'.$post->post_id)}}">READ MORE</a>
      </div>
    </div>
  @endforeach

  {{$posts->links('layouts.pagination')}}
@endsection

@section('meta')
  <meta name="description" content="{{$description}}" />
@endsection
