@extends('layouts.app')

@section('title', 'Add Product')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h3>Add Product</h3>
    </div>
    <hr>
    <form method="POST" action="{{ route('product.store') }}">
        @csrf
    
        <div class="form-group mb-3">
            <label for="product_code">Product Code</label>
            <input id="product_code" type="text" class="form-control @error('product_code') is-invalid @enderror" name="product_code" value="{{ old('product_code') }}" required autofocus placeholder="Kode Produk">
            @error('product_code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    
        <div class="form-group mb-3">
            <label for="product_name">Product Name</label>
            <input id="product_name" type="text" class="form-control @error('product_name') is-invalid @enderror" name="product_name" value="{{ old('product_name') }}" required placeholder="Nama Produk">
            @error('product_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    
        <div class="form-group mb-3">
            <label for="expired_date">Expired Date</label>
            <input id="expired_date" type="date" class="form-control @error('expired_date') is-invalid @enderror" name="expired_date" value="{{ old('expired_date') }}" required>
            @error('expired_date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    
        <div class="form-group mb-3">
            <label for="unit_price">Harga Satuan</label>
            <input id="unit_price" type="number" class="form-control @error('unit_price') is-invalid @enderror" name="unit_price" value="{{ old('unit_price') }}" required placeholder="Harga Satuan">
            @error('unit_price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    
        <div class="form-group mb-3">
            <label for="size">Size</label>
            <input id="size" type="text" class="form-control @error('size') is-invalid @enderror" name="size" value="{{ old('size') }}" required placeholder="Ukuran">
            @error('size')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    
        <div class="form-group mb-3">
            <label for="category">Category</label>
            <input id="category" type="text" class="form-control @error('category') is-invalid @enderror" name="category" value="{{ old('category') }}" required placeholder="Kategori">
            @error('category')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block w-100">
                Tambah Produk
            </button>
        </div>
    </form>    
</div>
@endsection
