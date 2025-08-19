<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Image extends Model
{
    use HasFactory;

    protected $fillable =['name','image'];

    public function uploadImage($file)
    {
        $name = time() . Str::uuid() . '.' . $file->getClientOriginalExtension();
        $destination = public_path('images/chatimage');
        $file->move($destination, $name);
        $this->image_path = 'images/chatimage/' . $name;
        return $this->image_path;

    }
}
