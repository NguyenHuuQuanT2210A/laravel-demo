<?php

namespace App\Http\Controllers;

use App\Events\CreateNewOrder;
use App\Mail\OrderMail;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Srmklive\PayPal\Services\PayPal as PayPalClient;


class HomeController extends Controller
{
    public function home(){
//        $categories = Category::all(); //moi phan tu la mot doi tuong cua model category
//        $products = Product::where("qty",">",30)
//            ->where("price",">",400)
//            ->where("name","like","%Olson%")
//            ->orderBy("created_at","desc")
//            ->limit(12)->get();   //limit() gioi han so luong skip: bo qua bao nhieu so luong get() tra ve mang
        $products = Product::orderBy("created_at","desc")->paginate(12);
        return view("pages.home",compact("products")); // compact("categories") xuất biến sang ben view
    }
    public function aboutUs(){
        return view("pages.aboutus");
    }


    public function category(Category $category){
        //dua vao id tim category neu ko ton tai -> 404
//        $category = Category::find($id);
//        if ($category == null){
//            return abort(404);
//        }

//        $category = Category::findOrFail($id);

        $products = Product::where("category_id","=",$category->id)->orderBy("created_at","desc")->paginate(12);
        return view("pages.category",compact("products"));
    }

    public function product(Product $product)
    {
        $relateds = Product::where("category_id",$product->id)
            ->where("id","!=",$product->id)
            ->where("qty",">",0)
            ->orderBy("created_at","desc")
            ->limit(4)
            ->get();
        return view("pages.product",compact("product","relateds"));
    }

    public function addToCart(Product $product, Request $request)
    {
        $buy_qty = $request->get("buy_qty");
        $cart = session()->has("cart")?session("cart"):[];
        foreach ($cart as $item)
        {
            if ($item->id == $product->id){
                $item->buy_qty = $item->buy_qty + $buy_qty;
                session(["cart"=>$cart]);
                return redirect()->back()->with("success","Da them so luong sp vao gio hang"); //back() ve trang vua moi them // with(): thogn bao
            }
        }
        $product->buy_qty = $buy_qty;
        $cart[] = $product;
        session(["cart"=>$cart]);
        return redirect()->back()->with("success","Da them sp moi vao gio hang");
    }

    public function cart(){
        $cart = session()->has("cart")?session("cart"):[];
        $subtotal = 0;
        $can_checkout = true;
        foreach ($cart as $item){
            $subtotal += $item->price * $item->buy_qty;
            if($item->buy_qty > $item->qty)
                $can_checkout = false;
        }
        $total = $subtotal*1.1; // vat: 10%

        return view("pages.cart",compact("cart","subtotal","total","can_checkout"));
    }
    public function checkout()
    {
        $cart = session()->has("cart")?session("cart"):[];
        $subtotal = 0;
        $can_checkout = true;
        foreach ($cart as $item){
            $subtotal += $item->price * $item->buy_qty;
            if($item->buy_qty > $item->qty)
                $can_checkout = false;
        }
        $total = $subtotal*1.1; // vat: 10%
        if(count($cart)==0 || !$can_checkout){
            return redirect()->to("cart");
        }
        return view("pages.checkout",compact("cart","subtotal","total"));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([     //validate([role,message]) neu kiem tra dl ko day du se back tro ve trang cu
            "full_name" => "required|min:6",  // la cac name cua input
            "address" => "required",
            "tel" =>  "required|min:9|max:11",
            "email" =>"required",
            "shipping_method" => "required",
            "payment_method" => "required"
        ],
        [
            "required"=>"Vui long nhap thong tin."
        ]);
        // calculate
        $cart = session()->has("cart")?session("cart"):[];
        $subtotal = 0;
        foreach ($cart as $item){
            $subtotal += $item->price * $item->buy_qty;
        }
        $total = $subtotal*1.1; // vat: 10%
        $order = Order::create([
            "grand_total"=>$total,
            "full_name"=>$request->get("full_name"),
            "email"=>$request->get("email"),
            "tel"=>$request->get("tel"),
            "address"=>$request->get("address"),
            "shipping_method"=>$request->get("shipping_method"),
            "payment_method"=>$request->get("payment_method")
        ]);
        foreach ($cart as $item){
            DB::table("order_products")->insert([
                "order_id"=>$order->id,
                "product_id"=>$item->id,
                "qty"=>$item->buy_qty,
                "price"=>$item->price
            ]);
            $product = Product::find($item->id);
            $product->update(["qty"=>$product->qty- $item->buy_qty]);
        }

        // clear cart
//        session()->forget("cart");
        event(new CreateNewOrder(($order)));

        //Thanh toan paypal
        if($order->payment_method == "Paypal"){
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();

            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => url("paypal-success",['order'=>$order]),
                    "cancel_url" => url("paypal-cancel",['order'=>$order]),
                ],
                "purchase_units" => [
                    0 => [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => number_format($order->grand_total,2,".","") // 1234.45
                        ]
                    ]
                ]
            ]);

            if (isset($response['id']) && $response['id'] != null) {

                // redirect to approve href
                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                        return redirect()->away($links['href']);
                    }
                }

                return redirect()
                    ->back()
                    ->with('error', 'Something went wrong.');

            } else {
                return redirect()
                    ->back()
                    ->with('error', $response['message'] ?? 'Something went wrong.');
            }
        }
        return redirect()->to("thank-you/$order->id");
    }
    public function thankYou(Order $order)
    {
//        $items = DB::table("order_products");
//            ->where("order_id",$order->id)
//            ->join("products","order_products.product_id","=","products.id")
//            ->select("products.id","products.name","products.thumbnail","order_products.price","order_products.qty")
//            ->get();

        return view("pages.thankyou",compact("order"));
    }

    public function paypalSuccess(Order $order)
    {
        $order->update([
            "is_paid"=>true,
            "status" => Order::CONFIRMED
        ]); // cap nhat trang thai da tra tien
        return redirect()->to("thank-you/$order->id");
    }
    public function paypalCancel(Order $order)
    {
        return redirect()->to("thank-you/$order->id");
    }
}
