<?php

use App\Models\Designation;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;

function findUser($id){

    $user = User::where('uuid',$id)->first();
    if ($user) {
        return ['success' => true, 'data' => $user];
    } else {
        return ['success' => false, 'message' => 'User not found'];
    }

}

function findRole($string){
    $role = Role::where('role',$string)->first();
    if($role){
        return ['success' => true, 'data' => $role];
    }else{
        return ['success' => false, 'message' => 'Role not found'];
    }
}

function findDesignation($id){

    $designation = Designation::where('uuid',$id)->first();
    if ($designation) {
        return ['success' => true, 'data' => $designation];
    } else {
        return ['success' => false, 'message' => 'Designation not found'];
    }

}

function findOrder($id){
    $order = Order::where('uuid',$id)->first();
    if($order){
        return ['success'=>true,'data'=>$order];
    }
    return ['success'=>false,'message'=>'Order Not Found'];
}
