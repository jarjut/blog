<div class="col-md-4 content-main-right">
  <div class="search">
    <h3>SEARCH HERE</h3>
    <form action="{{route('search')}}" method="post">
      {{ csrf_field() }}
      <input type="text" name="search" value="" onfocus="this.value=''" onblur="this.value=''">
      <button type="submit" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i></button>
    </form>
  </div>
  <div class="categories">
    <h3>CATEGORIES</h3>
    @foreach ($categories as $category)
      <li><a href="{{route('categoryposts', ['id'=>$category->category_id])}}">{{$category->name}}</a></li>
    @endforeach
  </div>
  <div class="categories">
    <h3>ANNOUNCEMENT</h3>
    @foreach ($announcement as $ann)
      <li><a href="{{route('viewpost', ['post'=>$ann->post_id])}}">{{$ann->title}}</a></li>
    @endforeach
  </div>
  {{-- <div class="archives">
    <h3>ARCHIVES</h3>
    <li class="active"><a href="#">July 2014</a></li>
    <li><a href="#">June 2014</a></li>
    <li><a href="#">May 2014</a></li>
  </div> --}}
</div>
