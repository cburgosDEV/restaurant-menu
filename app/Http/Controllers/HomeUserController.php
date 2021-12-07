<?php

namespace App\Http\Controllers;

use App\Architecture\Structure\Services\RestaurantService;
use Illuminate\Support\Facades\Auth;

class HomeUserController extends Controller
{
    protected $restaurantService;

    public function __construct(RestaurantService $restaurantService)
    {
        $this->restaurantService = $restaurantService;
    }

    public function index()
    {
        return view('homeUser');
    }

    public function jsonIndex($filterText = '')
    {
        return response()->json($this->restaurantService->getAllByUserPaginateToIndex($filterText, Auth::id()));
    }
}
