<?php

namespace App\Http\Controllers;

use App\Architecture\Structure\Services\UserService;
use App\Http\Request\StoreChangePassword;
use App\Http\Request\StoreUser;
use Illuminate\Support\Facades\Auth;

class ProfileController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('project_views.profile.index');
    }

    public function jsonIndex()
    {
        return response()->json($this->userService->getById(Auth::id()));
    }

    public function store(StoreUser $request)
    {
        $request->validated();

        return response()->json($this->userService->store($request));
    }

    public function changePassword(StoreChangePassword $request)
    {
        $request->validated();

        return response()->json($this->userService->changePassword($request));
    }
}
