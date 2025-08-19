<?php

namespace App\Http\Controllers;

use App\Services\InventoryService;
use App\Services\ValidationService;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public $inventoryService;

    public $validationService;

    public function __construct()
    {
        $this->inventoryService = new InventoryService();
        $this->validationService = new ValidationService();
    }

    public function addInventory(Request $request){
        $data = $this->inventoryService->addInventory($request);
        return response()->json($data);
    }
    public function updateInventory(Request $request){
        $data = $this->inventoryService->updateInventory($request);
        return response()->json($data);
    }
    public function deleteInventory(Request $request){
        $data = $this->inventoryService->deleteInventory($request);
        return response()->json($data);
    }
    public function getInventory(Request $request){
        $data = $this->inventoryService->getInventory($request);
        return response()->json($data);
    }
}