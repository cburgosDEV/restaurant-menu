<?php

namespace App\Http\Controllers;

use App\Architecture\Enums\CategoryTypeEnum;
use App\Architecture\Structure\Services\CategoryService;
use App\Http\Request\StoreCategory;

class CategoryController
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index($discriminator = 'RESTAURANT')
    {
        if(!($discriminator == CategoryTypeEnum::$RESTAURANT_DISCRIMINATOR || $discriminator == CategoryTypeEnum::$PLATE_DISCRIMINATOR)){
            $discriminator = CategoryTypeEnum::$RESTAURANT_DISCRIMINATOR;
        }
        return view('project_views.category.index', compact('discriminator'));
    }

    public function jsonIndex($discriminator, $filterText = '')
    {
        return response()->json($this->categoryService->getAllByDiscriminatorPaginateToIndex($filterText, $discriminator));
    }

    public function jsonCreate($discriminator)
    {
        $viewModel = $this->categoryService->getById(0);
        $viewModel['discriminator'] = $discriminator;
        return response()->json($viewModel);
    }

    public function store(StoreCategory $request)
    {
        $request->validated();

        return response()->json($this->categoryService->store($request));
    }

    public function jsonDetail($idCategory)
    {
        return response()->json($this->categoryService->getById($idCategory));
    }
}
