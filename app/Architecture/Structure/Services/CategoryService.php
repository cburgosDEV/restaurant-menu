<?php

namespace App\Architecture\Structure\Services;

use App\Architecture\Mappers\CategoryMapper;
use App\Architecture\Structure\Repositories\CategoryRepository;

class CategoryService
{
    protected $categoryRepository;
    protected $categoryMapper;

    public function __construct
    (
        CategoryRepository $categoryRepository,
        CategoryMapper $categoryMapper
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryMapper = $categoryMapper;
    }

    public function getById($id)
    {
        if($id == 0) return $this->categoryRepository->buildEmptyModel();
        return $this->categoryRepository->getById($id);
    }

    public function getAllByDiscriminator($filterText, $discriminator)
    {
        return  $this->categoryRepository->getAllByDiscriminator($filterText, $discriminator);
    }

    public function getAllByRestaurant($filterText, $idRestaurant)
    {
        return  $this->categoryRepository->getAllByRestaurant($filterText, $idRestaurant);
    }

    public function getAllByDiscriminatorPaginateToIndex($filterText, $discriminator)
    {
        return  $this->categoryRepository->getAllByDiscriminatorPaginateToIndex(10, $filterText, $discriminator);
    }

    public function store($request)
    {
        if($request->get('id') == 0) {
            $model = $this->categoryMapper->objectRequestToModel($request->all());

            return $this->categoryRepository->store($model);
        }
        else {
            $model = $this->categoryRepository->getById($request->get('id'));
            $model->fill($request->all());

            return $this->categoryRepository->store($model);
        }
    }
}
