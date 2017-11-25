<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $post_id
 * @property int $category_id
 * @property Post $post
 * @property Category $category
 */
class Kategoripost extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'kategoripost';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('App\Post', null, 'post_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Category', null, 'category_id');
    }
}
