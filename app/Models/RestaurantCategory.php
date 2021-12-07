<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantCategory extends Model
{
    protected $table = 'restaurant_category';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'state',
        'idRestaurant',
        'idCategory',
    ];
}
