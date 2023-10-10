@extends("admin.layouts.app")
@section("content")
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Quick Example</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{url("admin/product/edit",['product'=>$product->id])}}" method="post" enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" name="name" value="{{$product->name}}" class="form-control"  placeholder="Enter Name" required>
                    @error("name")
                    <p class="text-danger"><i>{{$message}}</i></p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Price</label>
                    <input type="number" value="{{$product->price}}" name="price" class="form-control"  placeholder="Price">
                    @error("price")
                    <p class="text-danger"><i>{{$message}}</i></p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Thumbnail</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input name="thumbnail" type="file" class="custom-file-input" id="exampleInputFile">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text">Upload</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Qty</label>
                    <input type="number" value="{{$product->qty}}" name="qty" class="form-control"  placeholder="Qty">
                    @error("qty")
                    <p class="text-danger"><i>{{$message}}</i></p>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select name="category_id" class="form-control">
                        <option value="">Choose category</option>
                        @foreach($categories as $item)
                            <option @if($item->id==$product->category_id) selected @endif value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                    @error("category_id")
                    <p class="text-danger"><i>{{$message}}</i></p>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" row="5">
                        {{$product->description}}
                    </textarea>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection
