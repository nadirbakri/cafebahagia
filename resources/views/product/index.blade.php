@extends('layouts.app')

@section('title', 'Product')

@section('content')


<div class="container">
    @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif
    @if (Session::has('fail'))
        <div class="alert alert-danger">
            {{ Session::get('fail') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center">
        <h3>Product List</h3>
        <a href="{{ route('product.create') }}" class="btn btn-primary">Add Product</a>
    </div>
    <hr>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Product Name</th>
                <th scope="col">Expired Date</th>
                <th scope="col">Price per Unit</th>
                <th scope="col">Size</th>
                <th scope="col">Category</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->expired_date)->format('l, F j, Y') }}</td>
                    <td>Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                    <td>{{ $item->size }}</td>
                    <td>{{ $item->category }}</td>
                    <td>
                        <form action="{{ route('product.edit', $item->id) }}" method="GET">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="badge bg-primary text-white">UPDATE</button>
                        </form>
                        <form action="{{ route('product.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="badge bg-danger text-white">DELETE</button>
                        </form>
                    </td>
                </tr>                
            @endforeach
        </tbody>
    </table>
</div>
@endsection
