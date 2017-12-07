@extends('layouts.master')

@section('content')
  @if (isset($headline))
    <div class="content-grid">
      <div class="content-grid-head">
        <h3>HEADLINE</h3>
        <h4>{{$headline->created_at->diffForHumans()}}, Posted by: <a href="#">{{$headline->user->username}}</a></h4>
        <div class="clearfix"></div>
      </div>
      <div class="content-grid-info">
      @if ($headline->image!=0)
        <div class="row">
          <div class="col-sm-5" >
            @if ($headline->image!=0)
              <a href="{{url('post/'.$headline->post_id)}}">
                <img src="{{asset('upload/imagepost/'.$headline->post_id.'.jpg')}}" alt=""/>
              </a>
            @endif
          </div>
          <div class="col-sm-7">
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
    @if (isset($headline))
      @if ($headline->post_id!=$post->post_id)
        <div class="content-grid-sec">
          <div class="content-sec-info">
            <h3><a href="{{url('post/'.$post->post_id)}}">{{$post->title}}</a></h3>
            <h4>{{$post->created_at->diffForHumans()}}, Posted by : <a href="#">{{$post->user->username}}</a></h4>
            <p>{{$post->description}}</p>
            <a href="{{url('post/'.$post->post_id)}}">View More</a>
            {{-- @if ($post->image!=0)
                <a href="{{url('post/'.$post->post_id)}}">
                <img src="{{asset('upload/imagepost/'.$post->post_id.'.jpg')}}" alt="" />
              </a>
            @endif --}}
            {{-- <a class="bttn" href="{{url('post/'.$post->post_id)}}">READ MORE</a> --}}
          </div>
        </div>
      @endif
    @else
      <div class="content-grid-sec">
        <div class="content-sec-info">
          <h3><a href="{{url('post/'.$post->post_id)}}">{{$post->title}}</a></h3>
          <h4>{{$post->created_at->diffForHumans()}}, Posted by : <a href="#">{{$post->user->username}}</a></h4>
          <p>{{$post->description}}</p>
          <a href="{{url('post/'.$post->post_id)}}">View More</a>
          {{-- @if ($post->image!=0)
              <a href="{{url('post/'.$post->post_id)}}">
              <img src="{{asset('upload/imagepost/'.$post->post_id.'.jpg')}}" alt="" />
            </a>
          @endif --}}
          {{-- <a class="bttn" href="{{url('post/'.$post->post_id)}}">READ MORE</a> --}}
        </div>
      </div>
    @endif

  @endforeach

  {{$posts->links('layouts.pagination')}}
@endsection

@section('meta')
<meta name="description" content="{{$description}}" />
@endsection

@section('ogmeta')
<meta property="og:type" content="website" />
  <meta property="og:title" content="{{$title}}" />
  <meta property="og:description" content="{{$description}}" />
  <meta property="og:url" content="{{url()->current()}}" />
@endsection
