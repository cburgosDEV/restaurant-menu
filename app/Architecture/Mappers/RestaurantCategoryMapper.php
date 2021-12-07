<?php

namespace App\Architecture\Mappers;

use App\Architecture\ViewModels\RestaurantCategoryViewModel;
use App\Models\RestaurantCategory;

class RestaurantCategoryMapper
{
    public function modelToViewModel(RestaurantCategory $model)
    {
        $viewModel = new RestaurantCategoryViewModel();

        return $viewModel->generateViewModel($model);
    }

    public function objectRequestToModel($object)
    {
        $model = new RestaurantCategory();
        $model->id = $object['id'];
        $model->state = $object['state'];
        $model->idRestaurant = $object['idRestaurant'];
        $model->idCategory = $object['idCategory'];

        return $model;
    }
}
