<?php

namespace App\Architecture\Structure\Repositories;

use App\Models\RestaurantCategory;

class RestaurantCategoryRepository extends RestaurantCategory
{
    public function buildEmptyModel()
    {
        return $emptyModel = [
            'id' => 0,
            'state' => true,
            'idRestaurant' => 0,
            'idCategory' => 0,
        ];
    }

    public function getById($id)
    {
        return RestaurantCategory::select('restaurant_category.*')
            ->where('restaurant_category.id', $id)
            ->first();
    }

    public function getByCategoryAndRestaurant($idRestaurant, $idCategory)
    {
        return RestaurantCategory::select('restaurant_category.*')
            ->where('restaurant_category.idRestaurant', $idRestaurant)
            ->where('restaurant_category.idCategory', $idCategory)
            ->first();
    }

    public function store(RestaurantCategory $restaurantCategory)
    {
        if($restaurantCategory->id == 0) {
            return $restaurantCategory->save();
        } else {
            return $restaurantCategory->update();
        }
    }

    public function getAllByRestaurant($idRestaurant)
    {
        return RestaurantCategory::select('restaurant_category.*')
            ->where('restaurant_category.idRestaurant', $idRestaurant)
            ->where('restaurant_category.state', true)
            ->get();
    }
}
