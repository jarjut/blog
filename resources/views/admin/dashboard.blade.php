@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{route('posts')}}">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$posts_count}}</h3>

              <p>Posts</p>
            </div>
            <div class="icon">
              <i class="fa fa-pencil" aria-hidden="true"></i>
            </div>
          </div>
        </a>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{route('comments')}}">
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$comments_count}}</h3>

              <p>Comments</p>
            </div>
            <div class="icon">
              <i class="fa fa-comments" aria-hidden="true"></i>
            </div>
          </div>
        </a>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{route('options')}}">
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3>Settings</h3>

            <p>Personalization</p>
          </div>
          <div class="icon">
            <i class="fa fa-wrench" aria-hidden="true"></i>
          </div>
        </div>
        </a>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{route('edituser')}}">
          <div class="small-box bg-red">
            <div class="inner">
              <h3>User</h3>

              <p>Edit User</p>
            </div>
            <div class="icon">
              <i class="fa fa-user" aria-hidden="true"></i>
            </div>
          </div>
        </a>
      </div>
      <!-- ./col -->
    </div>
    <div class="row">
      <div class="col-lg-6">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title" style="margin-right:8px;">Recent <a href="{{route('posts')}}">Posts</a></h3>
            <a href="{{route('newpost')}}">
              <button type="button" class="btn btn-sm btn-primary">Add New</button>
            </a>
          </div>
          <div class="box-body">
            <table id='postsTable' class="table table-bordered table-hover">
              @foreach ($posts as $post)
                <tr class="clickable-row" postId="{{$post->post_id}}" style="cursor: pointer;">
                  <td>{{$post->created_at->diffForHumans()}}</td>
                  <td>{{$post->title}}</td>
                </tr>
              @endforeach
            </table>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title" style="margin-right:8px;">Recent <a href="{{route('comments')}}">Comments</a></h3>
          </div>
          <div class="box-body">
            <table id='postsTable' class="table table-bordered table-hover">
              @foreach ($comments as $comment)
                <tr class="clickable-row" commentId="{{$comment->comment_id}}">
                  <td>
                  <p>From {{isset($comment->user_id) ? $comment->user->username : $comment->author_name}} on <a href="{{route('viewpost',['post'=>$comment->post->post_id])}}">{{$comment->post->title}}</a></p>
                    {{$comment->content}}
                    <div class="action_menu" style="display:none;">
                      <p>
                        @if (isset($comment->comment))
                          <a href="#" postId={{$comment->post->post_id}} comcommentId={{$comment->comment->comment_id}} class="reply">Reply</a> |
                        @else
                          <a href="#" postId={{$comment->post->post_id}} comcommentId={{$comment->comment_id}} class="reply">Reply</a> |
                        @endif
                        <a href="{{route('editcomment',['id'=>$comment->comment_id])}}">Edit</a> |
                        <a href="{{route('editcomment',['id'=>$comment->comment_id])}}" class="delete" style="color:red;">Delete</a>
                      </p>
                    </div>
                  </td>
                </tr>
              @endforeach
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Reply -->
    <div id="replyModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
      <form class="" action="{{route('replycommentadmin')}}" method="post">
        {{ csrf_field() }}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Reply Comment</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="comment">Comment:</label>
              <textarea class="form-control" rows="6" name="content" id="comment"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="post_id" value="">
            <input type="hidden" name="com_comment_id" value="">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </form>

      </div>
    </div>

    <form id="deleteForm" action="" method="post">
      <input type="hidden" name="_method" value="DELETE">
      {{ csrf_field() }}
    </form>
@stop

@section('js')
  <script>
    $(document).on("click", ".clickable-row", function () {
      var id = $(this).attr('postId');
      window.location = "posts/edit/"+id;
    });

    $(document).on('click', '.delete', function(event){
      event.preventDefault();
      var deleteForm = $('#deleteForm');
      deleteForm.attr('action', $(this).attr('href'));
      deleteForm.submit();
      return false;
    })

    $(document).on('click', '.reply', function(event){
      event.preventDefault();
      $("input[name='post_id']").val($(this).attr('postId'));
      $("input[name='com_comment_id']").val($(this).attr('comcommentId'));
      $('#replyModal').modal('show');
      return false;
    })

    $('.clickable-row').mouseenter(function(){
      $(this).find('div').show();
    })
    $('.clickable-row').mouseleave(function(){
      $(this).find('div').hide();
    })

    $('form').preventDoubleSubmission();
  </script>
@endsection
