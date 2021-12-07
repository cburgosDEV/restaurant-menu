<?php

namespace App\Architecture\ViewModels;

use App\Models\RestaurantCategory;

class RestaurantCategoryViewModel
{
    protected $id;
    protected $state;
    protected $idRestaurant;
    protected $idCategory;

    public function __construct()
    {

    }

    public function generateViewModel(RestaurantCategory $model)
    {
        $this->id = $model->id;
        $this->state = $model->state;
        $this->idRestaurant = $model->idRestaurant;
        $this->idCategory = $model->idCategory;

        return $this;
    }
}
