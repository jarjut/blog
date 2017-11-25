@extends('layouts.master')

@section('content')
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

@endsection
