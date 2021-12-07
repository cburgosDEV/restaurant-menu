<?php

namespace App\Architecture\Mappers;

use App\Architecture\ViewModels\RestaurantImageViewModel;
use App\Models\RestaurantImage;

class RestaurantImageMapper
{
    public function modelToViewModel(RestaurantImage $model)
    {
        $viewModel = new RestaurantImageViewModel();

        return $viewModel->generateViewModel($model);
    }

    public function objectRequestToModel($object)
    {
        $model = new RestaurantImage();
        $model->id = $object['id'];
        $model->url = $object['url'];
        $model->isPrincipal = $object['isPrincipal'];
        $model->state = $object['state'];
        $model->idRestaurant = $object['idRestaurant'];

        return $model;
    }
}
