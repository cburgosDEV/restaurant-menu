<?php

namespace App\Architecture\ViewModels;

use App\Models\Category;

class CategoryViewModel
{
    protected $id;
    protected $name;
    protected $discriminator;
    protected $state;
    protected $idRestaurant;

    public function __construct()
    {

    }

    public function generateViewModel(Category $model)
    {
        $this->id = $model->id;
        $this->name = $model->name;
        $this->discriminator = $model->discriminator;
        $this->state = $model->state;
        $this->idRestaurant = $model->idRestaurant;

        return $this;
    }
}
