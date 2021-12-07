<?php

namespace App\Architecture\Structure\Repositories;

use App\Models\RestaurantImage;

class RestaurantImageRepository extends RestaurantImage
{
    public function buildEmptyModel()
    {
        return $emptyModel = [
            'id' => 0,
            'url' => '',
            'isPrincipal' => false,
            'state' => true,
            'idRestaurant' => 0,
        ];
    }

    public function getById($id)
    {
        return RestaurantImage::select('restaurant_image.*')
            ->where('restaurant_image.id', $id)
            ->first();
    }

    public function getByDefault($id)
    {
        return RestaurantImage::select('restaurant_image.*')
            ->where('restaurant_image.id', $id)
            ->where('restaurant_image.isPrincipal', true)
            ->first();
    }

    public function store(RestaurantImage $restaurantImage)
    {
        if($restaurantImage->id == 0) {
            return $restaurantImage->save();
        } else {
            return $restaurantImage->update();
        }
    }

    public function getAllByRestaurant($idRestaurant)
    {
        return RestaurantImage::select('restaurant_image.*')
            ->where('restaurant_image.idRestaurant', $idRestaurant)
            ->where('restaurant_image.state', true)
            ->get();
    }
}
