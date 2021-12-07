<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantImage extends Model
{
    protected $table = 'restaurant_image';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'url',
        'isPrincipal',
        'state',
        'idRestaurant',
    ];
}
