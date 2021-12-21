<?php

namespace App\Architecture\Structure\Services;

use App\Architecture\Helpers\StoreImageHelper;
use App\Architecture\Mappers\RestaurantCategoryMapper;
use App\Architecture\Mappers\RestaurantImageMapper;
use App\Architecture\Mappers\RestaurantMapper;
use App\Architecture\Structure\Repositories\RestaurantCategoryRepository;
use App\Architecture\Structure\Repositories\RestaurantImageRepository;
use App\Architecture\Structure\Repositories\RestaurantRepository;
use Illuminate\Support\Facades\Storage;

class RestaurantService
{
    protected $restaurantRepository;
    protected $restaurantMapper;
    protected $restaurantImageRepository;
    protected $restaurantImageMapper;
    protected $restaurantCategoryRepository;
    protected $restaurantCategoryMapper;
    protected $storeImageHelper;

    public function __construct
    (
        RestaurantRepository $restaurantRepository,
        RestaurantMapper $restaurantMapper,
        RestaurantImageRepository $restaurantImageRepository,
        RestaurantImageMapper $restaurantImageMapper,
        RestaurantCategoryRepository $restaurantCategoryRepository,
        RestaurantCategoryMapper $restaurantCategoryMapper,
        StoreImageHelper $storeImageHelper
    )
    {
        $this->restaurantRepository = $restaurantRepository;
        $this->restaurantMapper = $restaurantMapper;
        $this->restaurantImageRepository = $restaurantImageRepository;
        $this->restaurantImageMapper = $restaurantImageMapper;
        $this->restaurantCategoryRepository = $restaurantCategoryRepository;
        $this->restaurantCategoryMapper = $restaurantCategoryMapper;
        $this->storeImageHelper = $storeImageHelper;
    }

    public function getById($id)
    {
        if($id == 0) return $this->restaurantRepository->buildEmptyModel();
        return $this->restaurantRepository->getById($id);
    }

    public function getAllPaginateToIndex($filterText)
    {
        return  $this->restaurantRepository->getAllPaginateToIndex(10, $filterText);
    }

    public function getAllByUserPaginateToIndex($filterText, $idUser)
    {
        return  $this->restaurantRepository->getAllByUserPaginateToIndex(10, $filterText, $idUser);
    }

    public function store($request, $idUser)
    {
        $listImage = $request->get('listImage');
        $listCategory = $request->get('listCategory');
        $listImageDelete = $request->get('listImageDelete');
        $listCategoryDelete = $request->get('listCategoryDelete');

        if($request->get('id') == 0) {
            //CREATE RESTAURANT
            $model = $this->restaurantMapper->objectRequestToModel($request->all());
            $model->idUser = $idUser;
            $response = $this->restaurantRepository->store($model);
            if(!is_numeric($response->id)) return $response;
            if($listImage != null && count($listImage)>0){
                //SAVE IMAGE
                $this->saveImage($listImage, $response->id);
            }
            if($listImage != null && count($listCategory)>0){
                //SAVE CATEGORY
                $this->saveCategory($listCategory, $response->id);
            }
            if($listImage != null && count($listCategoryDelete)>0){
                //DELETE CATEGORY
                $this->deleteCategory($listCategoryDelete, $response->id);
            }
            return $response;
        }
        else {
            //EDIT RESTAURANT
            $model = $this->restaurantRepository->getById($request->get('id'));
            $model->fill($request->all());
            $response = $this->restaurantRepository->store($model);

            if($listImage != null && count($listImage)>0){
                //SAVE IMAGE
                $this->saveImage($listImage, $request->get('id'));
            }
            if($listCategory != null && count($listCategory)>0){
                //SAVE CATEGORY
                $this->saveCategory($listCategory, $response->id);
            }
            if($listCategoryDelete != null && count($listCategoryDelete)>0){
                //DELETE CATEGORY
                $this->deleteCategory($listCategoryDelete, $response->id);
            }
            if(is_array($listImageDelete)){
                //DELETE IMAGE
                if(count($listImageDelete)>0){
                    $idImages = [];
                    $idImagesToDelete = [];
                    foreach ($request->get('images') as $image)
                    {
                        array_push($idImages, $image['id']);
                    }
                    for ($i=0; $i<count($idImages);$i++)
                    {
                        $aux = array_column($listImageDelete, 'id');
                        $index = array_search($idImages[$i], $aux);
                        if($index===false){
                            array_push($idImagesToDelete, $idImages[$i]);
                        }
                    }
                    foreach ($idImagesToDelete as $idImageToDelete)
                    {
                        $this->deleteImage($idImageToDelete);
                    }
                } else {
                    foreach ($request->get('images') as $imageToDelete)
                    {
                        $this->deleteImage($imageToDelete['id']);
                    }
                }
            }
            return $response;
        }
    }

    public function softDelete($request)
    {
        $model = $this->restaurantRepository->getById($request->get('id'));
        $model->fill($request->all());
        return $this->restaurantRepository->store($model);
    }

    public function saveImage($listImage, $idRestaurant)
    {
        foreach ($listImage as $image)
        {
            if($image['id']!=0){
                $this->deleteImageDefault($image['id']);
            }
        }
        foreach ($listImage as $image)
        {
            $restaurantImage = $this->restaurantImageRepository->getById($image['id']);
            if($restaurantImage==null){
                $restaurantImage = $this->restaurantImageRepository->buildEmptyModel();
                $responseImage = $this->storeImageHelper->storageImage($image['file'], "restaurants/$idRestaurant/");
                if($responseImage[0]) {
                    $restaurantImage['url'] = $responseImage[1];
                    $restaurantImage['isPrincipal'] = $image['highlight'] == 1 ?? false;
                    $restaurantImage['idRestaurant'] = $idRestaurant;
                    $restaurantImageModel = $this->restaurantImageMapper->objectRequestToModel($restaurantImage);
                    $this->restaurantImageRepository->store($restaurantImageModel);
                }
            } else {
                $restaurantImage['isPrincipal'] = $image['highlight'] == 1 ?? false;
                $this->restaurantImageRepository->store($restaurantImage);
            }
        }
    }

    public function deleteImageDefault($idRestaurantImage)
    {
        $restaurantImageDefault = $this->restaurantImageRepository->getByDefault($idRestaurantImage);
        if($restaurantImageDefault!=null){
            $restaurantImageDefault['isPrincipal'] = false;
            $this->restaurantImageRepository->store($restaurantImageDefault);
        }
    }

    public function deleteImage($idRestaurantImage)
    {
        $restaurantImage = $this->restaurantImageRepository->getById($idRestaurantImage);
        $restaurantImage['state'] = false;
        $this->restaurantImageRepository->store($restaurantImage);

        Storage::disk('public')->delete($restaurantImage['url']);
    }

    public function saveCategory($listCategory, $idRestaurant)
    {
        foreach ($listCategory as $category)
        {
            $restaurantCategory = $this->restaurantCategoryRepository->getByCategoryAndRestaurant($idRestaurant, $category);
            if($restaurantCategory==null) {
                $restaurantCategory = $this->restaurantCategoryRepository->buildEmptyModel();
                $restaurantCategory['idCategory'] = $category;
                $restaurantCategory['idRestaurant'] = $idRestaurant;
                $restaurantCategoryModel = $this->restaurantCategoryMapper->objectRequestToModel($restaurantCategory);
                $this->restaurantCategoryRepository->store($restaurantCategoryModel);
            } else {
                $restaurantCategory['state'] = true;
                $this->restaurantCategoryRepository->store($restaurantCategory);
            }
        }
    }

    public function deleteCategory($listCategoryDelete, $idRestaurant)
    {
        foreach ($listCategoryDelete as $category)
        {
            $restaurantCategory = $this->restaurantCategoryRepository->getByCategoryAndRestaurant($idRestaurant, $category['idCategory']);
            $restaurantCategory['state'] = false;
            $this->restaurantCategoryRepository->store($restaurantCategory);
        }
    }
}
