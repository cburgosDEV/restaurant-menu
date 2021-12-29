<?php

namespace App\Http\Controllers\Api;

use App\Architecture\Structure\Services\RestaurantService;
use App\Http\Controllers\Controller;

class RestaurantController extends Controller
{
    protected $restaurantService;

    public function __construct
    (
        RestaurantService $restaurantService
    )
    {
        $this->restaurantService = $restaurantService;
    }

    public function __invoke($filterText = "")
    {
        $restaurants = $this->restaurantService->getAllPaginateToIndex($filterText);
        return response()->json($restaurants);
    }
}
