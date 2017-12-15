@extends('layouts.master')

@section('content')
  <div class="content-grid-head">
    <h3>{{$title}}</h3>
    <div class="clearfix"></div>
  </div>
  @foreach ($posts as $post)
    @php
      $postlink = route('viewpostslug', [
        'year' => $post->created_at->format('Y'),
        'month' => $post->created_at->format('m'),
        'day' => $post->created_at->format('d'),
        'slug' => $post->slug]);
    @endphp
    <div class="content-grid-sec">
      <div class="content-sec-info">
        <h3><a href="{{$postlink}}">{{$post->title}}</a></h3>
        <h4>{{$post->created_at->diffForHumans()}}, Posted by : <a href="#">{{$post->user->username}}</a></h4>
        <p>{{str_limit(strip_tags($post->content), 350)}}</p>
        <a href="{{$postlink}}">View More</a>
        {{-- @if ($post->image!=0)
          <a href="{{$postlink}}">
            <img src="{{asset('upload/imagepost/'.$post->post_id.'.jpg')}}" alt="" />
          </a>
        @endif --}}
        {{-- <a class="bttn" href="{{$postlink}}">READ MORE</a> --}}
      </div>
    </div>
  @endforeach

  {{$posts->links('layouts.pagination')}}
@endsection
