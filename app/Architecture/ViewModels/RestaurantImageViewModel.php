<?php

namespace App\Architecture\ViewModels;

use App\Models\RestaurantImage;

class RestaurantImageViewModel
{
    protected $id;
    protected $url;
    protected $isPrincipal;
    protected $state;
    protected $idRestaurant;

    public function __construct()
    {

    }

    public function generateViewModel(RestaurantImage $model)
    {
        $this->id = $model->id;
        $this->url = $model->url;
        $this->isPrincipal = $model->isPrincipal;
        $this->state = $model->state;
        $this->idRestaurant = $model->idRestaurant;

        return $this;
    }
}
