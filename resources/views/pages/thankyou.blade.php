@extends("layouts.app")
@section("main")
    <div class="container">
        <h1 class="text-center">Thank you ^^</h1>
        <h3 class="text-center">Your Order #{{ $order->id }} has been placed</h3>
        <h3>Danh sach san pham cua don hang:</h3>
        <table class="table mt-3">
            <thead>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Total</th>
            </thead>
            <tbody>
            @foreach($order->Products as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td><img src={{$item->thumbnail}} alt="img" width="100px"></td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->pivot->price}}</td>
                    <td>{{$item->pivot->qty}}</td>
                    <td>{{$item->pivot->price * $item->pivot->qty}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @if($order->payment_method == "Paypal" && !$order->is_paid)
            <a href="#" class="btn btn-warning">Thanh toán lại</a>
        @endif
    </div>
@endsection
