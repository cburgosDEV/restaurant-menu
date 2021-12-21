<?php

namespace App\Architecture\Mappers;

use App\Architecture\ViewModels\PlateViewModel;
use App\Models\Plate;

class PlateMapper
{
    public function modelToViewModel(Plate $model)
    {
        $viewModel = new PlateViewModel();

        return $viewModel->generateViewModel($model);
    }

    public function objectRequestToModel($object)
    {
        $model = new Plate();
        $model->id = $object['id'];
        $model->name = $object['name'];
        $model->description = $object['description'];
        $model->price = $object['price'];
        $model->state = $object['state'];
        $model->avatar = $object['avatar'];
        $model->idCategory = $object['idCategory'];

        return $model;
    }
}
