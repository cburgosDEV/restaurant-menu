<?php

namespace App\Http\Controllers;

use App\Architecture\Structure\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        if($this->userService->getById(Auth::id())->getRoleNames()[0]=='super') return view('home');
        else return redirect('homeUser');
    }

    public function jsonIndex($filterText = '')
    {
        return response()->json($this->userService->getAllPaginateToIndexHome($filterText));
    }

    public function user()
    {
        return view('user');
    }
}
