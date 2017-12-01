@extends('layouts.master')

@section('content')
  <div class="content-grid-head">
    <h3>{{$title}}</h3>
    <div class="clearfix"></div>
  </div>
  @foreach ($posts as $post)

    <div class="content-grid-sec">
      <div class="content-sec-info">
        <h3><a href="{{url('post/'.$post->post_id)}}">{{$post->title}}</a></h3>
        <h4>{{$post->created_at->diffForHumans()}}, Posted by : <a href="#">{{$post->user->username}}</a></h4>
        <p>{{$post->description}}</p>
        <a href="{{url('post/'.$post->post_id)}}">View More</a>
        {{-- @if ($post->image!=0)
          <a href="{{url('post/'.$post->post_id)}}">
            <img src="{{asset('storage/imagepost/'.$post->post_id.'.jpg')}}" alt="" />
          </a>
        @endif --}}
        {{-- <a class="bttn" href="{{url('post/'.$post->post_id)}}">READ MORE</a> --}}
      </div>
    </div>
  @endforeach

  {{$posts->links('layouts.pagination')}}
@endsection
