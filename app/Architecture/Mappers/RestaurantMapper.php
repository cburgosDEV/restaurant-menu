<?php

namespace App\Architecture\Mappers;

use App\Architecture\ViewModels\RestaurantViewModel;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Hash;

class RestaurantMapper
{
    public function modelToViewModel(Restaurant $model)
    {
        $viewModel = new RestaurantViewModel();

        return $viewModel->generateViewModel($model);
    }

    public function objectRequestToModel($object)
    {
        $model = new Restaurant();
        $model->id = $object['id'];
        $model->name = $object['name'];
        $model->description = $object['description'];
        $model->address = $object['address'];
        $model->phone1 = $object['phone1'];
        $model->phone2 = $object['phone2'];
        $model->email = $object['email'];
        $model->web = $object['web'];
        $model->state = $object['state'];
        $model->idUser = $object['idUser'];

        return $model;
    }
}
