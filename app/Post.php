<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
// use Laravel\Scout\Searchable;

/**
 * @property int $post_id
 * @property int $user_id
 * @property string $title
 * @property string $content
 * @property integer $image
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property Comment[] $comments
 * @property Category[] $categories
 */
class Post extends Model
{

    use SoftDeletes;
    // use Searchable;

    protected $dates = ['deleted_at'];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'post_id';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'title', 'content', 'image', 'view'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment', 'post_id', 'post_id');
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($post) {
             $post->comments()->delete();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category', 'kategoripost', 'post_id', 'category_id');
    }

    public static function archieve()
    {
      return static::selectRaw('YEAR(created_at) year, MONTH(created_at) month, MONTHNAME(created_at) month_name, COUNT(*) post_count')
      ->groupBy('year','month','month_name')
      ->orderBy('year', 'desc')
      ->orderBy('month', 'desc')
      ->get();
    }
}
