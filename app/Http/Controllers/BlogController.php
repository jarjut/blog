<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Comment;
use App\Option;
use App\Post;
use App\User;

class BlogController extends Controller
{
    //
    public function showHomePage()
    {
      $data = array(
        //Selecting post where post is not announcement
        'posts' => Post::with(['user', 'comments', 'categories'])
        ->whereDoesntHave('categories', function($q){
          $q->where('kategoripost.category_id','=','2');
          })
        ->latest()->paginate(5),
        'headline' => Post::where('headline', 1)->with(['user', 'comments', 'categories'])->latest()->first(),
      );
      return view('home')->with($data);
    }

    public function showPost($post)
    {
      $data = array(
        'post' => Post::where('post_id', $post)->with(['user', 'comments', 'categories'])->first(),
        'comments' => Comment::where('post_id', $post)->where('com_comment_id', null)->with('comments')->latest()->get(),
      );

      return view('single')->with($data);
    }

    public function addComment(Request $req)
    {
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
      ->with(['user', 'comments', 'categories'])
      ->latest()
      ->paginate(5);
      $data = array(
        'posts' => $posts,
      );
      return view('multiple')->with($data);
    }

    public function showCategoryPosts($id)
    {
      $category = Category::where('category_id', $id)->first();
      $data = array(
        'posts' => $category->posts,
      );
      return view('multiple')->with($data);
    }
}
