<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Comment;
use App\Option;
use App\Post;
use App\User;
use Validator;

class BlogController extends Controller
{
    //
    public function showHomePage()
    {
      $data = array(
        //Selecting post where post is not announcement
        'posts' => Post::with(['user', 'comments', 'categories'])
        ->whereDoesntHave('categories', function($q){
          $q->where('kategoripost.category_id','2');
          })
        ->latest()->paginate(5),
      );
      return view('home')->with($data);
    }

    public function showPost($post)
    {
      $datapost = Post::where('post_id', $post)->with(['user', 'comments', 'categories'])->first();
      if (empty($datapost)) {
        abort(404);
      }
      return redirect()->route('viewpostslug', [
        'year' => $datapost->created_at->format('Y'),
        'month' => $datapost->created_at->format('m'),
        'day' => $datapost->created_at->format('d'),
        'slug' => $datapost->slug]);
    }

    public function showPostWithSlug($year, $month, $day, $slug)
    {
      $date = $year.'-'.$month.'-'.$day;
      $datapost = Post::whereDate('created_at', $date)
          ->where('slug', $slug)
          ->with(['user', 'categories'])->first();

      if (empty($datapost)) {
        abort(404);
      }

      $data = array(
        'post' => $datapost,
        'comments' => Comment::where('post_id', $datapost->post_id)->where('com_comment_id', null)->with('comments','user')->latest()->get(),
        'title' => $datapost->title
      );

      //Increment View Post
      $datapost->timestamps = false;
      $datapost->increment('view');
      $datapost->timestamps = true;


      return view('single')->with($data);
    }

    public function addComment(Request $req)
    {
      Validator::make($req->all(),[
        'name' => 'required|string',
        'email' => 'required|email',
        'g-recaptcha-response' => 'required'
      ])->validate();
      $comment = New Comment;
      $comment->post_id = $req->post;
      if (auth()->check()) {
        $comment->user_id = auth()->user()->user_id;
      }
      if (isset($req->com_comment_id)) {
        $comment->com_comment_id = $req->com_comment_id;
      }
      $comment->author_name = $req->name;
      $comment->author_email = $req->email;
      if (isset($req->url)) {
        $comment->author_url = $req->url;
      }
      $comment->content = $req->content;
      $comment->save();

      return redirect()->back();
    }

    public function search(Request $req)
    {
      $posts = Post::where('title','LIKE', '%'.$req->search.'%')
      ->orWhere('content','LIKE', '%'.$req->search.'%')
      ->orWhere('description','LIKE', '%'.$req->search.'%')
      ->orWhere('keywords','LIKE', '%'.$req->search.'%')
      ->with(['user', 'comments', 'categories'])
      ->latest()
      ->paginate(5);
      $data = array(
        'posts' => $posts,
        'title' => 'Search'
      );

      return view('multiple')->with($data);
    }

    public function showCategoryPosts($slug)
    {
      $category = Category::where('slug', $slug)->first();

      if (empty($category)) {
        abort(404);
      }
      $data = array(
        'posts' => $category->paginatePosts(5),
        'title' => $category->name
      );
      return view('multiple')->with($data);
    }

    public function showAnnouncementPage()
    {
      $data = array(
        //Selecting post where post is announcement
        'posts' => Post::with(['user', 'comments'])
        ->whereHas('categories', function($q){
          $q->where('kategoripost.category_id','2');
          })
        ->latest()->paginate(5),
        'title' => 'Announcement'
      );
      return view('multiple')->with($data);
    }
}
