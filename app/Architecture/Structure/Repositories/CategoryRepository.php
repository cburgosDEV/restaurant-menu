<?php

namespace App\Architecture\Structure\Repositories;

use App\Architecture\Helpers\PaginatorHelper;
use App\Models\Category;

class CategoryRepository
{
    public function buildEmptyModel()
    {
        return $emptyModel = [
            'id' => 0,
            'name' => '',
            'state' => true,
        ];
    }

    public function getById($id)
    {
        return Category::select('category.*')
            ->where('category.id', $id)
            ->first();
    }

    public function store(Category $category)
    {
        if($category->id == 0) {
            return $category->save();
        } else {
            return $category->update();
        }
    }

    public function getAllByDiscriminatorPaginateToIndex($pages, $filterText, $discriminator)
    {
        $model = Category::select('category.*')
            ->where('category.state', true)
            ->where('category.discriminator', $discriminator)
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
