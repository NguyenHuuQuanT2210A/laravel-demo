@extends("admin.layouts.app")
@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><a href="{{url("admin/product/create")}}">Create new product</a> </h3>

                    <div class="card-tools">
                        <form action="{{url("/admin/product")}}" method="get">
                            <div class="input-group input-group-sm mr-2" style="width: 100px; float:left">
                                <input class="form-control" type="number" name="price_from" placeholder="Price from"/>
                            </div>
                            <div class="input-group input-group-sm mr-2" style="width: 100px; float:left">
                                <input class="form-control" type="number" name="price_to" placeholder="Price to"/>
                            </div>
                            <div class="input-group input-group-sm mr-2" style="width: 150px; float:left">
                                <select name="category_id" class="form-control">
                                    <option value="0">Filter by category</option>
                                    @foreach($categories as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group input-group-sm" style="width: 150px;float:left">
                                <input value="{{app("request")->input("search")}}" type="text" name="search" class="form-control float-right" placeholder="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $item)
                            <tr>
                                <td>#{{$loop->index+1}}</td>
                                <td><img width="100" src="{{$item->thumbnail}}" /></td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->price}}</td>
                                <td>{{$item->qty}}</td>
                                <td>{{$item->Category->name}}</td>
                                <td>
                                    <a href="{{url("admin/product/edit",['product'=>$item->id])}}" class="btn btn-outline-info">Sửa</a>
                                    <form action="{{url("admin/product/delete",['product'=>$item->id])}}" method="POST">
                                        @csrf
                                        @method("DELETE")
                                        <button onclick="return confirm('Chắc chắn muốn xoá sản phẩm: {{$item->name}}')" class="btn btn-outline-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $products->links("pagination::bootstrap-4") !!}
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
