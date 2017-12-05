<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Post;
use Validator;

class PostController extends Controller
{
    //
    public function __construct()
    {

    }

    /*
    * All Posts
    */
    public function showPostsPage(){
      $data = array(
        //Selecting post where post is not announcement
        'posts'  => Post::with(['categories', 'user'])
        ->whereDoesntHave('categories', function($q){
          $q->where('kategoripost.category_id','=','2');
          })
        ->latest()->get(),
      );
      return view('admin.posts')->with($data);
    }

    /*
    * Add New Post
    */
    public function showNewPostPage(){
      $data = array(
        //Category without announcement and Uncategorized
        'categories'  => Category::whereNotIn('category_id', [1, 2])->get(),
      );
      return view('admin.newpost')->with($data);
    }

    public function addNewPost(Request $req)
    {
      $post = new Post;
      $post->user_id = auth()->user()->user_id;
      $post->title = $req->title;
      $post->description = $req->description;
      $post->content = $req->content;
      if (isset($req->headline)) {
        $post->headline = 1;
      }
      $post->save();
      if (isset($req->image)) {
        $req->validate([
          'image' => 'image|size:1000'
        ]);
        $post->image = 1;
        $path = $req->file('image')->storeAs('public/imagepost', $post->post_id.'.jpg');
        $post->save();
      }

      //Attach Category
      if (isset($req->categories)) {
        foreach ($req->categories as $category) {
          $post->categories()->attach($category);
        }
      //If category is null set to Uncategorized
      }else{
        $post->categories()->attach(1);
      }

      //Redirecting to edit post
      return redirect()->route('editpost', ['post' => $post->post_id])->with('status', 'Post Published');
    }

    /*
    * Edit Post
    */
    public function showEditPostPage($idpost, Request $req)
    {
      $data = array(
        'categories'  => Category::all(),
        'post'        => Post::where('post_id', $idpost)->with('categories')->first(),
      );

      return view('admin.editpost')->with($data);
    }

    public function editPost($idpost, Request $req)
    {
      $post = Post::where('post_id', $idpost)->first();
      $post->title = $req->title;
      $post->description = $req->description;
      $post->content = $req->content;
      if (isset($req->image)) {
        $post->image = 1;
        $path = $req->file('image')->storeAs('public/imagepost', $post->post_id.'.jpg');
      }
      $post->save();

      return redirect()->back()->with('status', 'Post Updated');
    }

    /*
    * Deleting Post
    */
    public function deletePost($idpost)
    {
      $post = Post::where('post_id', $idpost)->with('comments')->first();
      $post->delete();

      return redirect()->route('posts')->with('status', 'Post Deleted');
    }


    /*
    * Categories
    */
    public function showCategoriesPage()
    {
      $data = array(
        'categories'  => Category::where('category_id','!=', 2)->withCount('posts')->get(),
      );
      return view('admin.categories')->with($data);
    }

    public function addCategory(Request $req)
    {
      $category = Category::create([
        'name'  => $req->name
      ]);

      return redirect()->back();
    }

    /*
    * Announcement
    */
    public function showAnnouncementPage(){
      $data = array(
        //Selecting post where post is announcement
        'posts'  => Post::with(['categories', 'user'])
        ->whereHas('categories', function($q){
          $q->where('kategoripost.category_id','2');
          })
        ->latest()->get(),
      );
      return view('admin.announcement')->with($data);
    }

    /*
    * New Announcement
    */
    public function showNewAnnouncementPage(){

      return view('admin.newannouncement');
    }

    public function addNewAnnouncement(Request $req)
    {
      $post = new Post;
      $post->user_id = auth()->user()->user_id;
      $post->title = $req->title;
      $post->description = $req->description;
      $post->content = $req->content;
      $post->save();
      if (isset($req->image)) {
        $req->validate([
          'image' => 'image|size:1000'
        ]);
        $post->image = 1;
        $path = $req->file('image')->storeAs('public/imagepost', $post->post_id.'.jpg');
        $post->save();
      }

      //Attach to Announcement Category
      $post->categories()->attach(2);


      //Redirecting to edit post
      return redirect()->route('announcement')->with('status', 'Announcement Published');
    }



    public function getPostsCount()
    {
      $postCount = Post::count();

      return response()->json($postCount);
    }
}
