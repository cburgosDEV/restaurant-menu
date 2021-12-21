<?php

namespace App\Http\Controllers;

use App\Architecture\Structure\Services\RestaurantService;
use App\Architecture\Structure\Services\UserService;
use Illuminate\Support\Facades\Auth;

class HomeUserController extends Controller
{
    protected $restaurantService;
    protected $userService;

    public function __construct(RestaurantService $restaurantService, UserService $userService)
    {
        $this->restaurantService = $restaurantService;
        $this->userService = $userService;
    }

    public function index($idUser = 0)
    {
        if($idUser == 0 && Auth::user()->hasRole('super')) return redirect('');
        if($idUser != 0 && Auth::user()->hasRole('admin')) return redirect('homeUser');

        $userName = '';
        if($idUser != 0) $userName = $this->userService->getById($idUser)->name;
        return view('homeUser', compact('idUser', 'userName'));
    }

    public function jsonIndex($idUser = 0, $filterText = '')
    {
        if(Auth::user()->hasRole('super')) return response()->json($this->restaurantService->getAllByUserPaginateToIndex($filterText, $idUser));
        else return response()->json($this->restaurantService->getAllByUserPaginateToIndex($filterText, Auth::id()));
    }
}
