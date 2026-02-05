<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategory extends Model
{
        use HasFactory;
    protected $table = 'product_categories';

    protected $fillable = ['product_id', 'category_id'];

    public $timestamps = false;

    // /**
    //  * The attributes that should be cast to native types.
    //  *
    //  * @var array
    //  */
    // protected $casts = [
    //     'product_id' => 'integer',
    //     'category_id' => 'integer',
    // ];
}
