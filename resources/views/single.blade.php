@extends('layouts.master')


@section('content')
  <div id="fb-root"></div>
<script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.11';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>

  <div class="content-grid">
    <div class="content-grid-head">
      <h4>{{$post->created_at}}, Posted by: <a href="#">{{$post->user->username}}</a></h4>
      <div class="clearfix"></div>
    </div>
    <div class="content-grid-single">
      <h3>{{$post->title}}</h3>
      @if ($post->image!=0)
        <img class="single-pic" src="{{asset('storage/imagepost/'.$post->post_id.'.jpg')}}" alt=""/>
      @endif
      {!!$post->content!!}

      <br>
      <div class="fb-share-button"
        data-href="{{url()->current()}}"
        data-layout="button"
        data-size="large"
        data-mobile-iframe="true"
        >
      </div>

      <div class="content-form" id="commentform">
        <h3>Leave a comment</h3>
        <form action="{{route('addComment')}}" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="post" value="{{$post->post_id}}">
          <input type="text" name="name" placeholder="Name" required/>
          <input type="text" name="email" placeholder="E-mail" required/>
          <input type="hidden" name="com_comment_id" value="">
          <input type="text" name="url" placeholder="Website"/>
          <textarea name="content" placeholder="Message" required></textarea>
          <input type="submit" value="SEND"/>
        </form>
      </div>
      <div class="comments">
        <h3>Comments</h3>
        @foreach ($comments as $comment)
          <div class="comment-grid">
            <div class="comment-info" id="c{{$comment->comment_id}}" name="c{{$comment->comment_id}}">
              <h4>{{$comment->author_name}}</h4>
              <p>{{$comment->content}}</p>
              <h5>{{$comment->created_at}}</h5>
              <a href="#commentform" class="replyBtn" commentId="{{$comment->comment_id}}">Reply</a>
            </div>
            <div class="clearfix"></div>
          </div>
            @foreach ($comment->comments as $commentreply)
              <div class="comment-grid" style="margin-left:2em;">
                <div class="comment-info" id="c{{$commentreply->comment_id}}" name="c{{$commentreply->comment_id}}">
                  <h4>{{$commentreply->author_name}}</h4>
                  <p>{{$commentreply->content}}</p>
                  <h5>{{$commentreply->created_at}}</h5>
                </div>
                <div class="clearfix"></div>
              </div>
            @endforeach
        @endforeach
     </div>
     </div>

  </div>
@endsection

@section('meta')
  <meta name="description"  content="{{$post->description}}" />
  <meta property="og:url"           content="{{url()->current()}}" />
  <meta property="og:type"          content="website" />
  <meta property="og:title"         content="{{$post->title}}" />
  <meta property="og:description"   content="{{$post->description}}" />
  @if ($post->image!=0)
    <meta property="og:image"         content="{{asset('storage/imagepost/'.$post->post_id.'.jpg')}}" />
  @endif
@endsection

@section('js')
  <script type="text/javascript">
  $(document).on("click", ".replyBtn", function () {
   $("input[name='com_comment_id']").val($(this).attr('commentId'));
  });
  </script>
@endsection
