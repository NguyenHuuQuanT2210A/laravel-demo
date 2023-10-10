@extends("admin.layouts.app")
@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Responsive Hover Table</h3>

                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Created At</th>
                            <th>Grand Total</th>
                            <th>Full Name</th>
                            <th>Shipping Method</th>
                            <th>Payment Method</th>
                            <th>Paid</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $item)
                            <tr>
                                <td>#{{$loop->index+1}}</td>
                                <td>{{$item->created_at}}</td>
                                <td>{{$item->getGrandTotal()}}</td>
                                <td>{{$item->full_name}}</td>
                                <td>{{$item->shipping_method}}</td>
                                <td>{{$item->payment_method}}</td>
                                <td>{!! $item->getPaid() !!}</td>
                                <td>{!! $item->getStatus() !!}</td>
                                <td>
                                    <a href="#" class="btn btn-outline-info">Chi tiết</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $orders->links("pagination::bootstrap-4") !!}
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
