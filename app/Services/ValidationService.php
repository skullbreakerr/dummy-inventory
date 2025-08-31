<?php


namespace App\Services;

use Illuminate\Support\Facades\Validator;

class ValidationService{

    public function addClient($request){

        $rules = [
            'name'=>'required',
            'email'=>'required |unique:users,email',
            'mobile'=>'required',
            'company'=>'required',
            'address'=>'required',
            // 'alt_mobile'=>'required',
            // 'designation_uuid'=>'required',
            'password'=>'required'
        ];

        $validate = Validator::make($request->all(),$rules);
        if($validate->fails()){

                return [
                    'success'=>false,
                    'message'=>$validate->errors()->first()
                ];
        }

        return ['success'=>true];

    }
    public function productValidation($request, $endpoint){
        if($endpoint === 'add-product'){
            $rules = [
                'name'=>'required',
                'product_code'=>'required|unique:products,product_code',
            ];  
        }

        if ($endpoint === 'update-product' || $endpoint === 'delete-product') {
            $rules['id'] = 'required';
        }

        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return [
                'success' => false,
                'message' => $validate->errors()->first()
            ];
        }

        return ['success' => true];
    }

}
