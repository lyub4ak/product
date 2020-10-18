<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 *
 * @property Image[] $images
 */

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code',
    ];

    /**
     * The images that belong to the product.
     */
    public function images()
    {
        return $this->hasMany('App\Image')->orderBy('position');
    }
}
