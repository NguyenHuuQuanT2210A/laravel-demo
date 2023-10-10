@extends('admin.layouts.app')
@section('listname','Danh Sách Category')
@section('content')
    <div class="container">
        <div class="row">
            <table class="table mt-3">
                <thead>
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                </thead>
                <tbody>
                @foreach($categories as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{$item->name }}</td>
                        <td>{{$item->slug }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
