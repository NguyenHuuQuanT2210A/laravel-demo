@extends("layouts.app")
@section("main")
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h6><span class="icon_tag_alt"></span> Have a coupon? <a href="#">Click here</a> to enter your code
                </h6>
            </div>
        </div>
        <div class="checkout__form">
            <h4>Billing Details</h4>
            <form action="{{ url("/checkout") }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-8 col-md-6">
                        <div class="checkout__input">
                            <p>Full Name<span>*</span></p>
                            <input name="full_name" value="{{auth()?auth()->user()->name:old("full_name") }}" type="text">
                            @error("full_name")
                            <p class="text-danger"><i>{{ $message }}</i></p>
                            @enderror
                        </div>
                        <div class="checkout__input">
                            <p>Address<span>*</span></p>
                            <input name="address" value="{{ old("address") }}" type="text" placeholder="Street Address" class="checkout__input__add">
                            @error("address")
                            <p class="text-danger"><i>{{ $message }}</i></p>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Telephone<span>*</span></p>
                                    <input name="tel" value="{{ old("tel") }}" type="tel">
                                    @error("tel")
                                    <p class="text-danger"><i>{{ $message }}</i></p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Email<span>*</span></p>
                                    <input name="email" value="{{ auth()?auth()->user()->email:old("email") }}" type="email">
                                    @error("email")
                                    <p class="text-danger"><i>{{ $message }}</i></p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input__checkbox">
                            <p>Shipping method<span>*</span></p>
                            <label for="acc">
                                Express
                                <input name="shipping_method" @if(old("shipping_method") == "Express") checked @endif value="Express" type="radio" id="acc">
                                <span class="checkmark"></span>
                            </label>
                            <br/>
                            <label for="free">
                                Free Shipping
                                <input name="shipping_method" @if(old("shipping_method") == "Free_Shipping") checked @endif value="free_shipping" type="radio" id="free">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        @error("shipping_method")
                        <p class="text-danger"><i>{{ $message }}</i></p>
                        @enderror
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="checkout__order">
                            <h4>Your Order</h4>
                            <div class="checkout__order__products">Products <span>Total</span></div>
                            <ul>
                                @foreach($cart as $item)
                                    <li>{{$item->name}} (x{{$item->buy_qty}})<span>${{$item->price * $item->buy_qty}}</span></li>
                                @endforeach
                            </ul>
                            <div class="checkout__order__subtotal">Subtotal <span>${{$subtotal}}</span></div>
                            <div class="checkout__order__subtotal">VAT <span>10%</span></div>
                            <div class="checkout__order__total">Total <span>${{$total}}</span></div>

                            <div class="checkout__input__checkbox">
                                <label for="payment">
                                    COD
                                    <input name="payment_method" @if(old("payment_method") == "COD") checked @endif value="COD" type="radio" id="payment">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="checkout__input__checkbox">
                                <label for="paypal">
                                    Paypal
                                    <input name="payment_method" @if(old("payment_method") == "Paypal") checked @endif value="Paypal" type="radio" id="paypal">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            @error("payment_method")
                            <p class="text-danger"><i>{{ $message }}</i></p>
                            @enderror
                            <button type="submit" class="site-btn">PLACE ORDER</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
