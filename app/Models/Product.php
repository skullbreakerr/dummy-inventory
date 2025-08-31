<?php

namespace App\Models;
use App\Traits\setUUIdTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Product extends Model{
    use HasFactory, setUUidTrait;
    protected $table= 'products';
    protected $fillable = ['product_code','name','description','is_active','cost_price','image_path','is_customizable'];
    protected $casts =[
        'is_active'=>'boolean',
        'is_customizable'=>'boolean',
    ];
}