<?php

namespace App\Architecture\ViewModels;

use App\Models\Restaurant;

class RestaurantViewModel
{
    protected $id;
    protected $name;
    protected $description;
    protected $address;
    protected $phone1;
    protected $phone2;
    protected $email;
    protected $web;
    protected $state;
    protected $idUser;

    public function __construct()
    {

    }

    public function generateViewModel(Restaurant $model)
    {
        $this->id = $model->id;
        $this->name = $model->name;
        $this->description = $model->description;
        $this->address = $model->address;
        $this->phone1 = $model->phone1;
        $this->phone2 = $model->phone2;
        $this->email = $model->email;
        $this->web = $model->web;
        $this->state = $model->state;
        $this->idUser = $model->idUser;

        return $this;
    }
}
