<?php

namespace App\Http\Controllers;

use App\Architecture\Structure\Services\RestaurantService;
use App\Http\Request\StoreRestaurant;

class RestaurantController extends Controller
{
    protected $restaurantService;

    public function __construct(RestaurantService $restaurantService)
    {
        $this->restaurantService = $restaurantService;
    }

    public function index()
    {
        return view('project_views.restaurant.index');
    }

    public function create()
    {
        return view('project_views.restaurant.create');
    }

    public function jsonCreate()
    {
        return response()->json($this->restaurantService->getById(0));
    }

    public function store(StoreRestaurant $request)
    {
        $request->validated();
        return response()->json($this->restaurantService->store($request));
    }

    public function update($id)
    {
        return view('project_views.restaurant.update', compact('id'));
    }

    public function jsonUpdate($id)
    {
        return response()->json($this->restaurantService->getById($id));
    }
}
