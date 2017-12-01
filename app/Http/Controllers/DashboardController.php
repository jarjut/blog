<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Post;
use App\Comment;

class DashboardController extends Controller
{
    //
    public function __construct()
    {

    }

    public function index()
    {
      $data = array(
        'comments_count'  => Comment::count(),
        'posts_count'     => Post::count(),
        'comments'        => Comment::take(5)->latest()->with('user')->get(),
        'posts'           => Post::take(5)->latest()->get()
      );
      return view('admin.dashboard')->with($data);
    }


}
