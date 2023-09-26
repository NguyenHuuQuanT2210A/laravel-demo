@extends("layouts.app")
@section("main")
    <div class="container">
        @if(count($cart)==0)
            <p>Không có sản phẩm nào trong giỏ hàng</p>
        @else
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                            <tr>
                                <th class="shoping__product">Products</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cart as $item)
                                <tr>
                                    <td class="shoping__cart__item">
                                        <img src="{{$item->thumbnail}}" width="100" alt="">
                                        <h5>{{$item->name}}</h5>
                                    </td>
                                    <td class="shoping__cart__price">
                                        ${{$item->price}}
                                    </td>
                                    <td class="shoping__cart__quantity">
                                        <div class="quantity">
                                            <div class="pro-qty">
                                                <input type="text" value="{{$item->buy_qty}}">
                                            </div>
                                            @if($item->buy_qty > $item->qty)
                                                <p class="text-danger">Sản phẩm đã hết hàng</p>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="shoping__cart__total">
                                        ${{$item->price * $item->buy_qty}}
                                    </td>
                                    <td class="shoping__cart__item__close">
                                        <span class="icon_close"></span>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="#" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                        <a href="#" class="primary-btn cart-btn cart-btn-right"><span class="icon_loading"></span>
                            Upadate Cart</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__continue">
                        <div class="shoping__discount">
                            <h5>Discount Codes</h5>
                            <form action="#">
                                <input type="text" placeholder="Enter your coupon code">
                                <button type="submit" class="site-btn">APPLY COUPON</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <h5>Cart Total</h5>
                        <ul>
                            <li>Subtotal <span>${{$subtotal}}</span></li>
                            <li>VAT <span>10%</span></li>
                            <li>Total <span>${{$total}}</span></li>
                        </ul>
                        <a href="{{url("checkout")}}" class="primary-btn btn @if(!$can_checkout)disabled @endif">PROCEED TO CHECKOUT</a>
                    </div>
                </div>
            </div>
        @endif
    </div>

@endsection
