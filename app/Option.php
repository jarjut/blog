<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $option_id
 * @property string $option_name
 * @property string $option_value
 */
class Option extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'option_id';

    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['option_name', 'option_value'];

    public static function getOptionValue($option_name)
    {
      return static::where('option_name', $option_name)->first()->option_value;
    }

    public static function setOptionValue($option_name, $value)
    {
      return static::where('option_name', $option_name)->update(['option_value' => $value]);
    }

}
