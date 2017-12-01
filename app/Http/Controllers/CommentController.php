<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Validator;

class CommentController extends Controller
{
    //
    public function __construct()
    {

    }

    public function showCommentsPage()
    {
      $data = array(
        'comments'  => Comment::with(['user', 'post', 'comment'])->latest()->get(),
      );

      return view('admin.comments')->with($data);
    }

    public function addComment(Request $req)
    {
      $comment = New Comment;
      $comment->post_id = $req->post;
      if (auth()->check()) {
        $comment->user_id = auth()->user()->user_id;
      }else{
        $comment->user_id = 0;
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

    public function editCommentPage($id)
    {
      $comment = Comment::where('comment_id', $id)->with('post')->first();

      return view('admin.editcomment')->with('comment', $comment);
    }

    public function editComment($id, Request $req)
    {
      $comment = Comment::where('comment_id', $id)->first();
      $comment->author_name = $req->name;
      $comment->author_email = $req->email;
      if (isset($req->url)) {
        $comment->author_url = $req->url;
      }
      $comment->content = $req->content;
      $comment->save();

      return redirect()->back()->with('status', "Comment updated");
    }

    public function deleteComment($id)
    {
      $comment = Comment::where('comment_id', $id)->delete();

      return redirect()->route('comments')->with('status', 'Comment deleted');
    }

    public function replyCommentAdmin(Request $req)
    {
      $comment = New Comment;
      $comment->post_id = $req->post_id;
      $comment->com_comment_id = $req->com_comment_id;
      $comment->user_id = auth()->user()->user_id;
      $comment->author_name = auth()->user()->username;
      $comment->content = $req->content;
      $comment->save();

      return redirect()->back();

    }
}
