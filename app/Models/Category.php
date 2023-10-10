<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = "categories";
    protected $primaryKey = "id";
    //protected $primaryKey = "id"; // neu la id thi ko can viet lai
    protected $fillable =  //danh  sach cac cot duoc fill du lieu vao
        [
        "name",
            "slug"
    ];

    public function Products(){
        return $this->hasMany(Product::class); // 1 vs nhiều
    }

}
