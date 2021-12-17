<?php

namespace App\Http\Controllers;

use App\Architecture\Enums\CategoryTypeEnum;
use App\Architecture\Structure\Services\CategoryService;
use App\Architecture\Structure\Services\DropdownService;
use App\Architecture\Structure\Services\PlateService;
use App\Http\Request\StorePlate;
use Illuminate\Support\Facades\Auth;

class PlateController extends Controller
{
    protected $plateService;
    protected $dropdownService;
    protected $categoryService;

    public function __construct
    (
        PlateService $plateService,
        DropdownService $dropdownService,
        CategoryService $categoryService
    )
    {
        $this->plateService = $plateService;
        $this->dropdownService = $dropdownService;
        $this->categoryService = $categoryService;
    }

    public function index($id)
    {
        return view('project_views.plate.index', compact('id'));
    }

    public function jsonIndex($id, $filterText = '')
    {
        return response()->json($this->categoryService->getAllByRestaurant($filterText, $id));
    }

    public function jsonIndexPlate($id, $filterText = '')
    {
        return response()->json($this->plateService->getAllByCategoryPaginateToIndex($filterText, $id));
    }

    public function create()
    {
        return view('project_views.plate.create');
    }

    public function jsonCreate()
    {
        return response()->json($this->plateService->getById(0));
    }

    public function jsonUpdate($id)
    {
        return response()->json($this->plateService->getById($id));
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
