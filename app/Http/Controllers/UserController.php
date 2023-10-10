<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psy\Util\Str;

class UserController extends Controller
{
    public function homeAdmin()
    {
        return view("admin.pages.home");
    }

    public function listOrder()
    {
        $order = Order::orderBy("created_at","desc")->paginate(20);
        return view("admin.pages.listorder",compact("order"));
    }
    public function orderDetail()
    {
        $userAdmin = User::where("role","ADMIN")->get();
        $user = User::where("id","!=","1")->limit(1)->get();
        $order = Order::where("user_id","=","1")->get();
        return dd($order);
//        return view("admin.pages.orderdetail",compact("userAdmin","user","order"));
    }
    public function listProduct()
    {
        $products = Product::orderBy("created_at","desc")->paginate(20);
        return view("admin.pages.listproduct",compact("products"));
    }
    public function addProduct()
    {
        $category = Category::all();
        return view("admin.pages.addproduct",compact("category"));
    }
    public function insertProduct(Request $req)
    {
//        return dd($req);
        $productlist = Product::all();
        foreach ($productlist as $prd){
        if ($prd->name != $req->name){
            $req->validate([
                "name" => "required",
                "slug" => "required",
                "category_id" => "required",
                "price" => "required",
                "qty" => "required",
                "thumbnail" =>"required",
                "description" => "required"
            ],
                [
                    "required"=>"Vui long nhap thong tin."
                ]);
        }else{
            return redirect()->back()->with("danger","Ten san pham da ton tai");
        }
    }
        $thumbnail = null;
        //xu ly upload file
        if ($req->hasFile("thumbnail")){
            $path = public_path("uploads");
            $file = $req->file("thumbnail");
            $file_name = Str::random(5).time().Str::random(5).".".$file->getClientOriginalExtension();;
            $file->move($path,$file_name);
            die("done");
        } else{
            die("not done");
        }

        Product::create([
           "name"=> $req->get("name"),
            "slug" => $req->get("slug"),
            "category_id" => $req->get("category_id"),
            "price" => $req->get("price"),
            "qty" => $req->get("qty"),
            "thumbnail" =>$req->get("thumbnail"),
            "description" => $req->get("description")
        ]);
        return redirect()->back()->with("success","Tao san pham thanh cong");
    }

    public function editProduct(Product $product)
    {

        return view("admin.pages.editproduct",compact('product'));
    }

}
