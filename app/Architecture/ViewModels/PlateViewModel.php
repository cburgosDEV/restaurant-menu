<?php

namespace App\Architecture\ViewModels;

use App\Models\Plate;

class PlateViewModel
{
    protected $id;
    protected $name;
    protected $description;
    protected $price;
    protected $state;
    protected $avatar;
    protected $idCategory;

    public function __construct()
    {

    }

    public function generateViewModel(Plate $model)
    {
        $this->id = $model->id;
        $this->name = $model->name;
        $this->description = $model->description;
        $this->price = $model->price;
        $this->state = $model->state;
        $this->avatar = $model->avatar;
        $this->idCategory = $model->idCategory;

        return $this;
    }
}
