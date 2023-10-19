<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;
use Psy\Util\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
//        $products = Product::onlyTrashed()->orderBy("id","desc")->paginate(20); // chi lay nhung san pham da xoa
        //        $products = Product::withTrashed()->orderBy("id","desc")->paginate(20); // lay ca san pham chua xoa va da xoa

        $search = $request->get("search");
        $category_id = $request->get("category_id");
        $price_from = $request->get("price_from");
        $price_to = $request->get("price_to");
        $rate = $request->get("rate");
        $qty_from = $request->get("qty_from");
        $qty_to = $request->get("qty_to");
        // 1 (0) + 4 (1) + 6 (2) + 3(3) + 1(4) = 15
//        if($request->has("search") && $request->has("category_id")) {
//            $products = Product::where("category_id", $category_id)->where("name", 'like', "%$search%")->orderBy("id", "desc")->paginate(20);
//        }elseif($request->has("search") && !$request->has("category_id")){
//
//        }elseif(!$request->has("search") && $request->has("category_id")){
//
//        }else{
//            $products = Product::orderBy("id","desc")->paginate(20);
//        }
        $products = Product::Search($request)
            ->FilterCategory($request)
            ->FromPrice($request)
            ->ToPrice($request)
            ->orderBy("id","desc")
            ->paginate(20);
        // Scope search
        $categories = Category::all();
        return view("admin.pages.product.index",[
            "products"=>$products,
            'categories'=>$categories
        ]);
    }
    public function create()
    {
        $categories = Category::all();
        return view("admin.pages.product.create",compact("categories"));
    }
    public function store(Request $request)
    {
        $request->validate([
                "name"=>"required|min:6",
                "price"=>"required|numeric|min:0",
                "qty"=>"required|numeric|min:0",
                "category_id"=>"required|numeric|min:1",
                "thumbnail"=>"nullable|mimes:png,jpg,jpeg,gif|mimetypes:image/jpeg,image/png,image/jpg"
            //mines cho phep file truy cap minetypes : kiem tra tu ben trong file xem co phai la anh file.png/jpeg....
        ]);
       try{
           $thumbnail = null;
           //xu ly upload file
           if ($request->hasFile("thumbnail")){
           $path = public_path("uploads");
           $file = $request->file("thumbnail");
           $file_name = Str::random(5).time().Str::random(5).".".$file->getClientOriginalExtension(); //$file->getClientOriginalName() lay anh goc tu may cua minh len
            $file->move($path,$file_name);
            $thumbnail = "/uploads/".$file_name;
           }

           Product::create([
               "name"=>$request->get("name"),
               "slug"=> Str::slug($request->get("name")),
               "thumbnail"=>$thumbnail,
               "price"=>$request->get("price"),
               "qty"=>$request->get("qty"),
               "category_id"=>$request->get("category_id"),
               "description"=>$request->get("description"),
           ]);
           return redirect()->to("/admin/product")->with("success","Successfully");
       }catch (Exception $e){
           return redirect()->back()->withErrors($e->getMessage());
    }
    }

    public function edit(Product $product){
        $categories = Category::all();
        return view("admin.pages.product.edit",compact('product','categories'));
    }
    public function update(Product $product,Request $request){
        $request->validate([
            "name"=>"required|min:6",
            "price"=>"required|numeric|min:0",
            "qty"=>"required|numeric|min:0",
            "category_id"=>"required|numeric|min:1",
            "thumbnail"=>"nullable|mimes:png,jpg,jpeg,gif|mimetypes:image/jpeg,image/png,image/jpg"
        ]);
        try {
            $thumbnail = $product->thumbnail;
            // xu ly upload file
            if($request->hasFile("thumbnail")){
                $path = public_path("uploads");
                $file = $request->file("thumbnail");
                $file_name = Str::random(5).time().Str::random(5).".".$file->getClientOriginalExtension();
                $file->move($path,$file_name);
                $thumbnail = "/uploads/".$file_name;
            }
            $product->update([
                "name"=>$request->get("name"),
                "slug"=> Str::slug($request->get("name")),
                "thumbnail"=>$thumbnail,
                "price"=>$request->get("price"),
                "qty"=>$request->get("qty"),
                "category_id"=>$request->get("category_id"),
                "description"=>$request->get("description"),
            ]);
            return redirect()->to("/admin/product")->with("success","Successfully");
        }catch (\Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
    public function delete(Product $product){
        try {
            $product->delete();
            return redirect()->to("/admin/product")->with("success","Successfully");
        }catch (\Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

}
