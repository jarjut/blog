<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Post;
use Validator;
use Image;

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
        'categories'  => Category::whereNotIn('category_id', [1, 2])->orderBy('name','asc')->get(),
      );
      return view('admin.newpost')->with($data);
    }

    public function addNewPost(Request $req)
    {
      $req->validate([
        'image' => 'image|max:1024'
      ]);

      $post = new Post;
      $post->user_id = auth()->user()->user_id;
      $post->title = $req->title;
      $post->slug = str_slug($req->title, '-');
      $post->description = $req->description;
      $post->content = $req->content;
      if (isset($req->headline)) {
        $post->headline = 1;
      }
      $post->save();
      if (isset($req->image)) {
        $post->image = 1;
        $image = $req->image;
        $imagepost = Image::make($image->getRealPath());
        $imagepost->save(public_path('upload/imagepost/'.$post->post_id.'.jpg'));
        // $path = $req->file('image')->storeAs('public/imagepost', $post->post_id.'.jpg');
        $post->save();
      }

      //Attach Category
      if (isset($req->categories)) {
        $post->categories()->attach($req->categories);
      }else{
        //If category is null set to Uncategorized
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
      $post = Post::where('post_id', $idpost)->with('categories')->first();
      $category = $post->categories->first();
      $announcement = false;
      if ($category) {
        if ($category->category_id == 2) {
          $announcement = true;
        }
      }
      $data = array(
        //Category without announcement and Uncategorized
        'categories'  => Category::whereNotIn('category_id', [1, 2])->orderBy('name','asc')->get(),
        'post'        => $post,
        'announcement' => $announcement,
      );

      return view('admin.editpost')->with($data);
    }

    public function editPost($idpost, Request $req)
    {
      $post = Post::where('post_id', $idpost)->first();
      $post->title = $req->title;
      $post->slug = str_slug($req->title, '-');
      $post->description = $req->description;
      $post->content = $req->content;
      if (isset($req->image)) {
        $req->validate([
          'image' => 'image|max:1024'
        ]);
        $post->image = 1;
        $image = $req->image;
        $imagepost = Image::make($image->getRealPath());
        $imagepost->save(public_path('upload/imagepost/'.$post->post_id.'.jpg'));
        // $path = $req->file('image')->storeAs('public/imagepost', $post->post_id.'.jpg');
      }
      $post->save();

      //Check if not announcement
      if (empty($req->announcement)) {
        //Attach Category
        if (isset($req->categories)) {
          $post->categories()->sync($req->categories);
        }else{
          //If category is null set to Uncategorized
          $post->categories()->detach();
          $post->categories()->attach(1);
        }
      }

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
        'categories'  => Category::where('category_id','!=', 2)->withCount('posts')->orderBy('posts_count','desc')->get(),
      );
      return view('admin.categories')->with($data);
    }

    public function addCategory(Request $req)
    {
      $category = new Category;
      $category->name = $req->name;
      $category->slug = str_slug($req->name, '-');
      $category->save();

      return redirect()->back();
    }

    public function editCategory(Request $req)
    {
      // if not Uncategorized or announcement
      if ($req->id!=1||$req->id!=2) {
        $category = Category::find($req->id);
        $category->name = $req->name;
        $category->slug = str_slug($req->name, '-');
        $category->save();
      }

      return redirect()->back()->with('status', 'Category Updated');
    }

    public function deleteCategory(Request $req)
    {
      // if not Uncategorized or announcement
      if ($req->id!=1||$req->id!=2) {
        $category = Category::find($req->id);
        $category->posts()->detach();
        $category->delete();
      }


      return redirect()->back()->with('status', 'Category Deleted');
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
      $req->validate([
        'image' => 'image|max:1024'
      ]);

      $post = new Post;
      $post->user_id = auth()->user()->user_id;
      $post->title = $req->title;
      $post->slug = str_slug($req->title, '-');
      $post->description = $req->description;
      $post->content = $req->content;
      $post->save();
      if (isset($req->image)) {
        $post->image = 1;
        $image = $req->image;
        $imagepost = Image::make($image->getRealPath());
        $imagepost->save(public_path('upload/imagepost/'.$post->post_id.'.jpg'));
        // $path = $req->file('image')->storeAs('public/imagepost', $post->post_id.'.jpg');
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
