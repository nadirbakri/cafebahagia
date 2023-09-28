@extends('layouts.app')

@section('title', 'Transaction')

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
        <h3>Transaction</h3>
    </div>
    <hr>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Product Name</th>
                <th scope="col">Price</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $item->product_name }}</td>
                    <td>Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                    <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal{{ $item->id }}" data-price="{{ $item->unit_price }}">
                            ORDER
                        </button>
                    </td>
                </tr>                
            @endforeach
        </tbody>
    </table>
</div>

@foreach ($data as $item)
    <div class="modal fade" id="myModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ORDER DETAIL</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('transaction.store', $item->id) }}">
                        @csrf
                    
                        <div class="form-group mb-3">
                            <label for="order_date">Date</label>
                            <input id="order_date{{ $item->id }}" type="date" class="form-control @error('order_date') is-invalid @enderror" name="order_date" value="{{ date('Y-m-d') }}" required autofocus placeholder="Date" readonly style="background-color: #f2f2f2;">
                            @error('order_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="order_number">Order Number</label>
                            <input id="order_number" type="text" class="form-control @error('order_number') is-invalid @enderror" name="order_number" value="{{ old('order_number') }}" required autofocus placeholder="Order Number">
                            @error('order_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="customer_name">Customer Name</label>
                            <input id="customer_name" type="text" class="form-control @error('customer_name') is-invalid @enderror" name="customer_name" value="{{ old('customer_name', auth()->user()->name) }}" required autofocus placeholder="Customer Name" readonly style="background-color: #f2f2f2;">
                            @error('customer_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="product_name">Product</label>
                            <input id="product_name" type="text" class="form-control @error('product_name') is-invalid @enderror" name="product_name" value="{{ old('product_name', $item->product_name) }}" required autofocus placeholder="Product" readonly style="background-color: #f2f2f2;">
                            <input id="product_id" type="hidden" class="form-control @error('product_id') is-invalid @enderror" name="product_id" value="{{ old('product_id', $item->id) }}" required>
                            @error('product_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="quantity">Quantity</label>
                            <div class="input-group">
                                <button class="btn btn-outline-primary" type="button" id="decrement{{ $item->id }}">-</button>
                                <input id="quantity{{ $item->id }}" type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="1" min="1" required>
                                <button class="btn btn-outline-primary" type="button" id="increment{{ $item->id }}">+</button>
                            </div>
                            @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="total_price">Total Price</label>
                            <input id="total_price{{ $item->id }}" type="text" class="form-control" name="total_price" value="Rp {{ number_format($item->unit_price, 0, ',', '.') }}" readonly style="background-color: #f2f2f2;">
                        </div>
                
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block w-100">
                                ORDER
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const quantityInput{{ $item->id }} = document.getElementById('quantity{{ $item->id }}');
        const totalPriceInput{{ $item->id }} = document.getElementById('total_price{{ $item->id }}');
        const unitPrice{{ $item->id }} = parseFloat({{ $item->unit_price }});
    
        function formatRupiah{{ $item->id }}(value) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(value);
        }
    
        function calculateTotalPrice{{ $item->id }}() {
            const quantity{{ $item->id }} = parseInt(quantityInput{{ $item->id }}.value);
            const total{{ $item->id }} = quantity{{ $item->id }} * unitPrice{{ $item->id }};
            totalPriceInput{{ $item->id }}.value = formatRupiah{{ $item->id }}(total{{ $item->id }});
        }
    
        document.getElementById('increment{{ $item->id }}').addEventListener('click', () => {
            quantityInput{{ $item->id }}.value = parseInt(quantityInput{{ $item->id }}.value) + 1;
            calculateTotalPrice{{ $item->id }}();
        });
    
        document.getElementById('decrement{{ $item->id }}').addEventListener('click', () => {
            const currentQuantity{{ $item->id }} = parseInt(quantityInput{{ $item->id }}.value);
            if (currentQuantity{{ $item->id }} > 1) {
                quantityInput{{ $item->id }}.value = currentQuantity{{ $item->id }} - 1;
                calculateTotalPrice{{ $item->id }}();
            }
        });
    
        quantityInput{{ $item->id }}.addEventListener('input', calculateTotalPrice{{ $item->id }});
    
        calculateTotalPrice{{ $item->id }}();
    </script>
        
@endforeach

@endsection
