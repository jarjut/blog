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
            <th>Author</th>
            <th>Categories</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($posts as $post)
            <tr class="clickable-row" postId="{{$post->post_id}}" style="cursor: pointer;">
              <td>{{$post->title}}</td>
              <td>{{$post->user->username}}</td>
              <td>@foreach ($post->categories as $category)
                    {{$category->name}},
                  @endforeach
              </td>
              <td>{{$post->created_at}}</td>
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
@stop

@section('js')
  <script>
    $(function () {
      $('#postsTable').DataTable({
        "order": [[3, 'desc']],
        "columns": [
          { "width": "20%"},
          { "width": "50%"},
          { "width": "15%"},
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
