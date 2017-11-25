@extends('adminlte::page')

@section('title', 'User')

@section('content_header')
    <h1>User</h1>
@endsection

@section('content')
  @if ($errors->any())
    <div class="callout callout-danger" role="callout">
      <ul>
      @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
      @endforeach
      </ul>
    </div>
  @endif
  @if (session('status'))
    <div class="callout callout-success" role="callout">
      {{session('status')}}
    </div>
  @endif
  @if (session('error'))
    <div class="callout callout-danger" role="callout">
      {{session('error')}}
    </div>
  @endif
  <form class="" action="{{route('edituser')}}" method="post">
    {{ csrf_field() }}
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Username</h3>
      </div>
      <div class="box-body">
        <input type="text" name="username" class="form-control" value="{{auth()->user()->username}}" required>
      </div>
    </div>
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Password</h3>
      </div>
      <div class="box-body">
        <div class="form-group">
          <label for="">Old Password</label>
          <input type="password" name="oldpassword" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="">New Password</label>
          <input type="password" name="newpassword" class="form-control">
        </div>
        <div class="form-group">
          <label for="">Password Confirmation</label>
          <input type="password" name="newpassword_confirmation" class="form-control">
        </div>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Save Changes</button>
  </form>
@endsection
