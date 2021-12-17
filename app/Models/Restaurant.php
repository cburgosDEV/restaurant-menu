<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $table = 'restaurant';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'description',
        'address',
        'phone1',
        'phone2',
        'email',
        'web',
        'state',
        'idUser',
    ];

    public function images()
    {
        return $this->hasMany('App\Models\RestaurantImage', 'idRestaurant');
    }

    public function categories()
    {
        return $this->hasMany('App\Models\RestaurantCategory', 'idRestaurant');
    }

    public function scopeFiltersToIndex($query, $filters)
    {
        $query->where('restaurant.name', 'like', '%' . $filters . '%');
    }
}
