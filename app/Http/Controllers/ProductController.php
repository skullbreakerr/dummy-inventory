<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Services\ValidationService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public $productService;

    public $validationService;

    public function __construct()
    {
        $this->productService = new ProductService();
        $this->validationService = new ValidationService();
    }

    public function addProduct(Request $request){
        $isValid = $this->validationService->productValidation($request, 'add-product');
        if(!$isValid['success']){
            return response()->json($isValid);
        }
        $data = $this->productService->addProduct($request);
        return response()->json($data);
    }
    public function updateProduct(Request $request){
        $isValid = $this->validationService->productValidation($request, 'update-product');
        if(!$isValid['success']){
            return response()->json($isValid);
        }
        $data = $this->productService->updateProduct($request);
        return response()->json($data);
    }
    public function deleteProduct(Request $request){
        $isValid = $this->validationService->productValidation($request, 'delete-product');
        if(!$isValid['success']){
            return response()->json($isValid);
        }
        $data = $this->productService->deleteProduct($request);
        return response()->json($data);
    }
    public function getProduct(Request $request){
        $data = $this->productService->getProduct($request);
        return response()->json($data);
    }
}