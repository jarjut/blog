<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'BlogController@showHomePage')->name('home');
Route::get('/post/{post}', 'BlogController@showPost')->name('viewpost');
Route::post('comment', 'BlogController@addComment')->name('addComment');
Route::post('search', 'BlogController@search')->name('search');
Route::get('category/{id}' ,'BlogController@showCategoryPosts')->name('categoryposts');



Route::prefix('admin')->group(function () {
  Route::get('/', function(){
    return redirect()->route('dashboard');
  });
  Route::get('login', 'LoginController@showLoginForm')->name('login');
  Route::post('login', 'LoginController@login');
  Route::post('logout', 'LoginController@logout')->name('logout');

  Route::middleware('auth')->group(function(){
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::prefix('posts')->group(function(){
      Route::get('all', 'PostController@showPostsPage')->name('posts');
      Route::get('new', 'PostController@showNewPostPage')->name('newpost');
      Route::post('new', 'PostController@addNewPost');
      Route::get('edit/{post}' ,'PostController@showEditPostPage')->name('editpost');
      Route::post('edit/{post}', 'PostController@editPost');
      Route::delete('edit/{post}', 'PostController@deletePost');
    });
    Route::get('categories', 'PostController@showCategoriesPage')->name('categories');
    Route::post('categories', 'PostController@addCategory');
    Route::get('comments', 'CommentController@showCommentsPage')->name('comments');
    Route::post('comments/reply', 'CommentController@replyCommentAdmin')->name('replycommentadmin');
    Route::get('comments/edit/{id}', 'CommentController@editCommentPage')->name('editcomment');
    Route::post('comments/edit/{id}', 'CommentController@editComment');
    Route::delete('comments/edit/{id}', 'CommentController@deleteComment');
    Route::get('options', 'OptionController@showOptionPage')->name('options');
    Route::post('options', 'OptionController@saveOption');
    Route::get('user', 'UserController@showEdit')->name('edituser');
    Route::post('user', 'UserController@edit');
    Route::prefix('announcement')->group(function(){
      Route::get('all', 'PostController@showAnnouncementPage')->name('announcement');
      Route::get('new', 'PostController@showNewAnnouncementPage')->name('newannouncement');
      Route::post('new', 'PostController@addNewAnnouncement');
    });
  });
});

Route::prefix('get')->group(function(){
  Route::get('posts', 'PostController@getPosts');
});
