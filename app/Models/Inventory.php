<?php

namespace App\Models;
use App\Traits\setUUIdTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Inventory extends Model{
    use HasFactory, setUUidTrait;
    protected $table= 'inventory';
    protected $fillable = ['item','status'];

    protected $casts =[
        'item'=>'array',
    ];
}