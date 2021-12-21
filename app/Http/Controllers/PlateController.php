<?php

namespace App\Http\Controllers;

use App\Architecture\Enums\CategoryTypeEnum;
use App\Architecture\Structure\Services\CategoryService;
use App\Architecture\Structure\Services\DropdownService;
use App\Architecture\Structure\Services\PlateService;
use App\Architecture\Structure\Services\RestaurantService;
use App\Http\Request\StorePlate;
use Illuminate\Support\Facades\Auth;

class PlateController extends Controller
{
    protected $plateService;
    protected $dropdownService;
    protected $categoryService;
    protected $restaurantService;

    public function __construct
    (
        PlateService $plateService,
        DropdownService $dropdownService,
        CategoryService $categoryService,
        RestaurantService $restaurantService
    )
    {
        $this->plateService = $plateService;
        $this->dropdownService = $dropdownService;
        $this->categoryService = $categoryService;
        $this->restaurantService = $restaurantService;
    }

    public function index($idRestaurant = 0)
    {
        $restaurant = $this->restaurantService->getById($idRestaurant);
        if(Auth::user()->hasRole('admin') && ($restaurant == null || $restaurant['idUser'] != Auth::id())) return redirect('homeUser');

        return view('project_views.plate.index', compact('idRestaurant'));
    }

    public function jsonIndex($idRestaurant, $filterText = '')
    {
        return response()->json([
            'categories' => $this->categoryService->getAllByRestaurant($filterText, $idRestaurant),
            'restaurantName' => $this->restaurantService->getById($idRestaurant)->name
        ]);
    }

    public function jsonIndexPlate($idPlate, $filterText = '')
    {
        return response()->json($this->plateService->getAllByCategory($filterText, $idPlate));
    }

    public function jsonCreate($idPlate = 0)
    {
        return response()->json($this->plateService->getById(0));
    }

    public function jsonDetail($idPlate)
    {
        return response()->json($this->plateService->getById($idPlate));
    }

    public function store(StorePlate $request)
    {
        $request->validated();
        return response()->json($this->plateService->store($request));
    }

    public function softDelete(StorePlate $request)
    {
        $request->validated();
        return response()->json($this->plateService->softDelete($request));
    }
}
