@extends('adminlte::page')

@section('title', 'Categories')

@section('content_header')
    <h1>Categories</h1>
@endsection

@section('content')
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
              <input type="text" name="name" class="form-control" placeholder="Enter Category Name">
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
                <tr class="clickable-row" categoryId="{{$category->category_id}}" style="cursor: pointer;">
                  <td>{{$category->name}}</td>
                  <td>{{$category->posts_count}}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
