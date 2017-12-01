@extends('adminlte::page')

@section('title', 'Comments')

@section('content_header')
    <h1>Comments</h1>
@stop

@section('content')
  @if (session('status'))
    <div class="callout callout-success" role="callout">
      {{session('status')}}
    </div>
  @endif
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title" style="margin-right:8px;">Comments</h3>
    </div>
    <div class="box-body">
      <table id='postsTable' class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>Author</th>
            <th>Comment</th>
            <th>Response To</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($comments as $comment)
            <tr class="clickable-row" commentId="{{$comment->comment_id}}">
              <td>{{isset($comment->user_id) ? $comment->user->username : $comment->author_name}}</td>
              <td>@if (isset($comment->comment))
              <p>In reply to <a href="{{route('viewpost',['post'=>$comment->post->post_id])}}#c{{$comment->comment->comment_id}}">{{$comment->comment->author_name}}</a></p>
              @endif
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
              <td><a href="{{route('viewpost',['post'=>$comment->post->post_id])}}">{{$comment->post->title}}</a></td>
              <td>{{$comment->created_at->diffForHumans()}}</td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th>Author</th>
            <th>Comment</th>
            <th>Response To</th>
            <th>Date</th>
          </tr>
        </tfoot>
      </table>
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

  <script type="text/javascript">
    $(document).ready(function(){
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

    })
  </script>

  <script>
    $(function () {
      $('#postsTable').DataTable({
        "ordering": false,
        "columns": [
          { "width": "10%"},
          { "width": "60%"},
          { "width": "15%"},
          { "width": "15%"}
        ]
      })
    })

    $(document).on("click", ".clickable-row", function () {
      var id = $(this).attr('commentId');
      window.location = "comments/edit/"+id;
    });
    $('form').preventDoubleSubmission();

  </script>
@endsection
