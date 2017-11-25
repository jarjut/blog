@extends('adminlte::page')

@section('title', 'Appearance')

@section('content_header')
    <h1>Appearance</h1>
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
  </div>
@endsection
