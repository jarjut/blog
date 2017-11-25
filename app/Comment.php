<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $comment_id
 * @property int $post_id
 * @property int $com_comment_id
 * @property int $user_id
 * @property string $author_name
 * @property string $author_email
 * @property string $author_url
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property Comment $comment
 * @property Post $post
 */
class Comment extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'comment_id';

    /**
     * @var array
     */
    protected $fillable = ['post_id', 'com_comment_id', 'user_id', 'author_name', 'author_email', 'author_url', 'content', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comment()
    {
        return $this->belongsTo('App\Comment', 'com_comment_id', 'comment_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'com_comment_id', 'comment_id')->latest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('App\Post', 'post_id', 'post_id');
    }
}
