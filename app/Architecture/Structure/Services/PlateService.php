<?php

namespace App\Architecture\Structure\Services;

use App\Architecture\Helpers\StoreImageHelper;
use App\Architecture\Mappers\PlateMapper;
use App\Architecture\Structure\Repositories\PlateRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class PlateService
{
    protected $plateRepository;
    protected $plateMapper;
    protected $storeImageHelper;

    public function __construct
    (
        PlateRepository $plateRepository,
        PlateMapper $plateMapper,
        StoreImageHelper $storeImageHelper
    )
    {
        $this->plateRepository = $plateRepository;
        $this->plateMapper = $plateMapper;
        $this->storeImageHelper = $storeImageHelper;
    }

    public function getById($id)
    {
        if($id == 0) return $this->plateRepository->buildEmptyModel();
        return $this->plateRepository->getById($id);
    }

    public function getAllPaginateToIndex($filterText)
    {
        return $this->plateRepository->getAllPaginateToIndex(10, $filterText);
    }

    public function getAllByCategoryPaginateToIndex($filterText, $idCategory)
    {
        return $this->plateRepository->getAllByCategoryPaginateToIndex(10, $filterText, $idCategory);
    }

    public function store($request)
    {
        if($request->get('id') == 0) {
            $model = $this->plateMapper->objectRequestToModel($request->all());
            $model->assignRole(Role::findByName($request->get('role')));

            return $this->plateRepository->store($model);
        }
        else {
            $model = $this->plateRepository->getById($request->get('id'));
            $model->fill($request->all());

            //DELETE IMAGE
            if($request->get('isImageDeleted') && $request->get('avatar')!='avatar.png'){
                Storage::disk('public')->delete($model['avatar']);
                $model['avatar'] = 'avatar.png';
            }

            //SAVE IMAGE
            if($request->get('image')!=null){
                $image = $request->get('image');
                $responseImage = $this->storeImageHelper->storageImage($image, "plates/");
                if($responseImage[0]) $model['avatar'] = $responseImage[1];
            }

            return $this->plateRepository->store($model);
        }
    }

    public function softDelete($request)
    {
        $model = $this->plateRepository->getById($request->get('id'));
        $model->fill($request->all());
        return $this->plateRepository->store($model);
    }
}
