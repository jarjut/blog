@extends('layouts.master')

@section('title', $title)

@section('content')
  <div class="content-grid">
    <div class="content-grid-head">
      <h4>{{$post->created_at->diffForHumans()}}, Posted by: <a href="#">{{$post->user->username}}</a></h4>
      <div class="clearfix"></div>
    </div>
    <div class="content-grid-single">
      <h3>{{$post->title}}</h3>
      <div class="text-center">
        @if ($post->image!=0)
          <img class="single-pic" src="{{asset('upload/imagepost/'.$post->post_id.'.jpg')}}" alt=""/>
        @endif
      </div>
      {!!$post->content!!}
      <p><b>Post Views: {{$post->view}}</b></p>
      <br>
      <div class="social">
        <h4>Share On</h4>
        <a class="social-link social-twitter" href="https://twitter.com/intent/tweet?text={{$post->title}}&amp;url={{url()->current()}}&amp;" target="_blank">Twitter</a>
        <a class="social-link social-facebook" href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}" target="_blank">Facebook</a>
        <a class="social-link social-whatsapp" href="whatsapp://send?text={{$post->title}} {{url()->current()}}" target="_blank">WhatsApp</a>
        <a class="social-link social-googleplus" href="https://plus.google.com/share?url={{url()->current()}}" target="_blank">Google+</a>
        <a class="social-link social-linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url={{url()->current()}}&amp;title={{$post->title}}" target="_blank">LinkedIn</a>
      </div>

      <div class="content-form" id="commentform">
        <h3>Leave a comment</h3>
        <form action="{{route('addComment')}}" method="post" id="commentForm">
          {{ csrf_field() }}
          <input type="hidden" name="post" value="{{$post->post_id}}">
          <input type="text" name="name" placeholder="Name" id="inputname" required/>
          <input type="text" name="email" placeholder="E-mail" required/>
          <input type="hidden" name="com_comment_id" value="">
          <input type="text" name="url" placeholder="Website"/>
          <textarea name="content" placeholder="Message" required></textarea>
          <div class="g-recaptcha" data-sitekey="6Lfb4ToUAAAAABITE4aCaBoLuRnLEexuw3VTvdXm"></div>
          <input type="submit" value="SEND"/>
        </form>
      </div>
      <div class="comments">
        <h3>Comments</h3>
        @foreach ($comments as $comment)
          <div class="comment-grid">
            <div class="comment-info" id="c{{$comment->comment_id}}" name="c{{$comment->comment_id}}">
              <h4>{!!isset($comment->user_id) ? $comment->user->username.' <i class="fa fa-user" aria-hidden="true"></i>' : $comment->author_name!!}</h4>
              <p>{{$comment->content}}</p>
              <h5>{{$comment->created_at->diffForHumans()}}</h5>
              <a href="#commentform" class="replyBtn" commentId="{{$comment->comment_id}}">Reply</a>
            </div>
            <div class="clearfix"></div>
          </div>
            @foreach ($comment->comments as $commentreply)
              <div class="comment-grid" style="margin-left:2em;">
                <div class="comment-info" id="c{{$commentreply->comment_id}}" name="c{{$commentreply->comment_id}}">
                  <h4>{!!isset($commentreply->user_id) ? $commentreply->user->username.' <i class="fa fa-user" aria-hidden="true"></i>' : $commentreply->author_name!!}</h4>
                  <p>{{$commentreply->content}}</p>
                  <h5>{{$commentreply->created_at->diffForHumans()}}</h5>
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
@endsection

@section('ogmeta')
<meta property="og:description"   content="{{$post->description}}" />
  <meta property="og:title"         content="{{$post->title}}" />
  <meta property="og:url"           content="{{url()->current()}}" />
  <meta property="og:type"          content="article" />
  @if ($post->image!=0)
    <meta property="og:image"         content="{{asset('upload/imagepost/'.$post->post_id.'.jpg')}}" />
  @endif
@endsection

@section('css')
  <link rel="stylesheet" href="{{asset('css/custom.css')}}">
@endsection
@section('js')
  <script type="text/javascript">
  $(document).on("click", ".replyBtn", function (e) {
    e.preventDefault();
    $("input[name='com_comment_id']").val($(this).attr('commentId'));
    $("#inputname").focus();
  });
  $('form').preventDoubleSubmission();
  </script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection
