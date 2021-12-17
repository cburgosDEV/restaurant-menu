<?php

namespace App\Architecture\Structure\Repositories;

use App\Architecture\Helpers\PaginatorHelper;
use App\Models\Plate;

class PlateRepository
{
    public function buildEmptyModel()
    {
        return $emptyModel = [
            'id' => 0,
            'name' => '',
            'description' => '',
            'price' => '',
            'state' => '',
            'image' => '',
            'idCategory' => '',
        ];
    }

    public function getById($id)
    {
        return Plate::select('plate.*')
            ->where('plate.id', $id)
            ->first();
    }

    public function store(Plate $plate)
    {
        if($plate->id == 0) {
            $plate->save();
        } else {
            $plate->update();
        }
        return $plate;
    }

    public function getAllPaginateToIndex($pages, $filterText)
    {
        $model = Plate::select('plate.*')
            ->where('plate.state', true)
            ->orderBy('plate.name')
            ->filtersToIndexPlate($filterText)
            ->paginate($pages);

        $paginatorHelper = new PaginatorHelper();
        $paginate = $paginatorHelper->paginateModel($model);

        return [
            'model' => $model->all(),
            'paginate' => $paginate
        ];
    }

    public function getAllByCategoryPaginateToIndex($pages, $filterText, $idCategory)
    {
        $model = Plate::select('plate.*')
            ->where('plate.state', true)
            ->where('plate.idCategory', $idCategory)
            ->orderBy('plate.name')
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
