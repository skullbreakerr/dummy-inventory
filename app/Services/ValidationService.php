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

    public function userUUIDValidation($request){
        $rules = [
           'user_uuid'=>'required'
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
    public function addOrder($request){
        $rules = [
           'client'=>'required',
           'technology_uuid'=>'required',
           'material_uuid'=>'required',
           'confirmation_date'=>'required|before_or_equal:expected_delivery_date',
           'expected_delivery_date'=>'required',
           'description'=>'required',
           'inquiry_date'=>'required|before_or_equal:confirmation_date',

           'value'=>'required',
           'quantity_of_parts'=>'required',
           'finish_status'=>'required',
           'payment_status'=>'required',
           'length'=>'required',
           'width'=>'required',
           'height'=>'required',

        //    'files.*' => 'required|file'
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
    public function orderUUIDValidation($request){
        $rules = [
           'order_uuid'=>'required',
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
    public function addTechnology($request){
        $rules = [
           'name'=>'required',
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
    public function technologyUUIDValidation($request){
        $rules = [
           'technology_uuid'=>'required',
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

    public function addMaterial($request){
        $rules = [
            'technology_uuid'=>'required',
            'name'=>'required',
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
    public function materialUUIDValidation($request){
        $rules = [
            'material_uuid'=>'required',
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
    public function addService($request){
        $rules = [
            'name'=>'required',
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
    public function serviceUUIDValidation($request){
        $rules = [
            'service_uuid'=>'required',
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

    public function addSubService($request){
        $rules = [
            'service_uuid'=>'required',
            'name'=>'required'
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
    public function subuServiceerviceUUIDValidation($request){
        $rules = [
            'sub_service_uuid'=>'required',
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

    public function addKnowledgeCenter($request){
        $rules = [
            'sub_service'=>'required',
            'service'=>'required',
            'title'=>'required',
            'description'=>'required',
            'short_description'=>'required',
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
    public function setCenterUUIDValidation($request){
        $rules = [
            'center_uuid'=>'required',
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
}
