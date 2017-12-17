@extends('adminlte::page')

@section('title', 'Categories')

@section('content_header')
    <h1>Categories</h1>
@endsection

@section('content')
  @if (session('status'))
    <div class="callout callout-success" role="callout">
      {{session('status')}}
    </div>
  @endif
  <div class="row">
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Add Category</h3>
        </div>
        <div class="box-body">
          <form class="" action="{{route('categories')}}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" name="name" class="form-control" placeholder="Enter Category Name" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title" style="margin-right:8px;">All Categories</h3>
        </div>
        <div class="box-body">
          <table id='postsTable' class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Name</th>
                <th>Posts</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($categories as $category)
                <tr class="{{$category->category_id!=1 ? 'clickable-row' : ''}}" categoryId="{{$category->category_id}}" style="cursor: pointer;">
                  <td class="cell-name">{{$category->name}}</td>
                  <td><a href="{{route('categoryposts', ['slug' => $category->slug])}}" target="_blank">{{$category->posts_count}}</a></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Reply -->
  <div id="replyModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
    <form class="" action="{{route('editcategory')}}" method="post">
      {{ csrf_field() }}
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Category</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="name">Name</label>
            <input type="hidden" name="id" class="editid" value="">
            <input type="text" name="name" class="form-control editname" placeholder="Enter Category Name">
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="post_id" value="">
          <input type="hidden" name="com_comment_id" value="">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button id="delete" class="btn btn-danger">Delete</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>

    </div>
  </div>

  <form id="deleteForm" action="{{route('editcategory')}}" method="post">
    <input type="hidden" name="_method" value="DELETE">
    <input class="editid" type="hidden" name="id" value="">
    {{ csrf_field() }}
  </form>

@endsection
@section('js')
<script src="https://unpkg.com/sweetalert2@7.1.0/dist/sweetalert2.all.js"></script>

  <!-- Include a polyfill for ES6 Promises (optional) for IE11 and Android browser -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
  <script type="text/javascript">
    $(document).on("click", ".clickable-row", function () {
      var id = $(this).attr('categoryId');
      var name = $(this).find('td.cell-name').html();
      $('.editname').val(name);
      $('.editid').val(id);
      $('#replyModal').modal('show');
    });

    $(document).on('click', '#delete', function(event){
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

    $('form').preventDoubleSubmission();
  </script>
@endsection
