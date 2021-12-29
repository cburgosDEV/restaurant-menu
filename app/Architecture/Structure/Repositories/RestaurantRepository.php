<?php

namespace App\Architecture\Structure\Repositories;

use App\Architecture\Helpers\PaginatorHelper;
use App\Models\Restaurant;

class RestaurantRepository
{
    public function buildEmptyModel()
    {
        return $emptyModel = [
            'id' => 0,
            'name' => '',
            'description' => '',
            'address' => '',
            'phone1' => '',
            'phone2' => '',
            'email' => '',
            'web' => '',
            'state' => true,
            'idUser' => 0,
            'images' => [],
            'categories' => [],
        ];
    }

    public function getById($id)
    {
        return Restaurant::select('restaurant.*')
            ->where('restaurant.id', $id)
            ->with(['images' => function ($query){
                $query->orderBy('isPrincipal', 'DESC');
            }])
            ->with(['categories' => function ($query){
                $query->where('state', true);
            }])
            ->first();
    }

    public function store(Restaurant $restaurant)
    {
        if($restaurant->id == 0) {
            $restaurant->save();
        } else {
            $restaurant->update();
        }
        return $restaurant;
    }

    public function getAllPaginateToIndex($pages, $filterText)
    {
        $model = Restaurant::select('restaurant.*')
            ->where('restaurant.state', true)
            ->orderBy('restaurant.name')
            ->filtersToIndex($filterText)
            ->paginate($pages);

        $paginatorHelper = new PaginatorHelper();
        $paginate = $paginatorHelper->paginateModel($model);

        return [
            'model' => $model->all(),
            'paginate' => $paginate
        ];
    }

    public function getAllByUserPaginateToIndex($pages, $filterText, $idUser)
    {
        $model = Restaurant::select('restaurant.*')
            ->where('restaurant.state', true)
            ->where('restaurant.idUser', $idUser)
            ->orderBy('restaurant.name')
            ->filtersToIndex($filterText)
            ->paginate($pages);

        $paginatorHelper = new PaginatorHelper();
        $paginate = $paginatorHelper->paginateModel($model);

        return [
            'model' => $model->all(),
            'paginate' => $paginate
        ];
    }
}
