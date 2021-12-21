<?php

namespace App\Http\Controllers;

use App\Architecture\Enums\CategoryTypeEnum;
use App\Architecture\Structure\Services\DropdownService;
use App\Architecture\Structure\Services\RestaurantService;
use App\Http\Request\StoreRestaurant;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    protected $restaurantService;
    protected $dropdownService;

    public function __construct
    (
        RestaurantService $restaurantService,
        DropdownService $dropdownService
    )
    {
        $this->restaurantService = $restaurantService;
        $this->dropdownService = $dropdownService;
    }

    public function index()
    {
        return view('project_views.restaurant.index');
    }

    public function create($idUser = 0)
    {
        if($idUser != 0 && Auth::user()->hasRole('admin')) return redirect('homeUser');
        return view('project_views.restaurant.create', compact('idUser'));
    }

    public function jsonCreate()
    {
        return response()->json($this->restaurantService->getById(0));
    }

    public function update($id)
    {
        $restaurant = $this->restaurantService->getById($id);
        if(Auth::user()->hasRole('admin') && ($restaurant == null || $restaurant['idUser'] != Auth::id())) return redirect('homeUser');

        return view('project_views.restaurant.update', compact('id'));
    }

    public function jsonUpdate($id)
    {
        return response()->json(
            [
                'viewModel' => $this->restaurantService->getById($id),
                'restaurantCategoryDropdown' => $this->dropdownService->CategoryDropdown(CategoryTypeEnum::$RESTAURANT_DISCRIMINATOR)
            ]
        );
    }

    public function store(StoreRestaurant $request)
    {
        $request->validated();
        if(Auth::user()->hasRole('admin')) return response()->json($this->restaurantService->store($request, Auth::id()));
        else return response()->json($this->restaurantService->store($request, $request->get('idUser')));
    }

    public function softDelete(StoreRestaurant $request)
    {
        $request->validated();
        return response()->json($this->restaurantService->softDelete($request));
    }
}
