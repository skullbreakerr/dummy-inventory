<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use App\Services\ValidationService;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    public $apiService;

    public $validationService;

    public function __construct()
    {
        $this->apiService = new ApiService();
        $this->validationService = new ValidationService();
    }


    public function askQuestion(Request $request){
        $data = $this->apiService->askQuestion($request);
        return response()->json($data);
    }

    public function userDetails(){

        $response = $this->apiService->userDetails();
        return response()->json($response);
    }

    public function UploadImage(Request $request)
    {
        $response = $this->apiService->UploadImage($request);
        return $response;
    }

}

