@extends('adminlte::page')

@section('title', 'Posts')

@section('content_header')
    <h1>All Posts</h1>
@stop

@section('content')
  @if (session('status'))
    <div class="callout callout-success" role="callout">
      {{session('status')}}
    </div>
  @endif
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title" style="margin-right:8px;">Posts</h3>
      <a href="{{route('newpost')}}">
        <button type="button" class="btn btn-sm btn-primary">Add New</button>
      </a>
    </div>
    <div class="box-body">
      <table id='postsTable' class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Categories</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($posts as $post)
            <tr class="clickable-row" postId="{{$post->post_id}}" style="cursor: pointer;">
              <td>{{$post->title}}</td>
              <td>{{$post->description}}
                <div class="action_menu" style="display:none;">
                  <p>
                    <a href="{{route('editpost',['post'=>$post->post_id])}}">Edit</a> |
                    <a href="{{route('editpost',['post'=>$post->post_id])}}" class="delete" style="color:red;">Delete</a>
                  </p>
                </div>
              </td>
              <td>@foreach ($post->categories as $category)
                    {{$category->name}},
                  @endforeach
              </td>
              <td>{{$post->created_at->diffForHumans()}}</td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Categories</th>
            <th>Date</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
  <form id="deleteForm" action="" method="post">
    <input type="hidden" name="_method" value="DELETE">
    {{ csrf_field() }}
  </form>
@stop

@section('js')
<script src="https://unpkg.com/sweetalert2@7.1.0/dist/sweetalert2.all.js"></script>

  <!-- Include a polyfill for ES6 Promises (optional) for IE11 and Android browser -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      $(document).on('click', '.delete', function(event){
        event.preventDefault();
        var deleteForm = $('#deleteForm');
        deleteForm.attr('action', $(this).attr('href'));
        swal({
          title: 'Are you sure?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.value) {
            deleteForm.submit();
          }
        })
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
          { "width": "15%"},
          { "width": "50%"},
          { "width": "20%"},
          { "width": "15%"}
        ]
      })
    })

    $(document).on("click", ".clickable-row", function () {
      var id = $(this).attr('postId');
      window.location = "edit/"+id;
    });
  </script>
@endsection
