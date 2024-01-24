@extends('layouts.app')

@section('title')
    Edit Product
@endsection

@section('content')	
    <!-- Page Header -->
    <div class="d-block mb-4 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="#"><svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg></a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('products.index') }}">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
            </ol>
        </nav>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="h5 mb-4">Update Product</h2>
                    <form action="{{ route('products.update', $product->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="settings-form">
                            <div class="row">
                                <div class="col-sm-9 mb-3">
                                    <div class="form-group">
                                        <label for="product_name">Name</label> 
                                        <input class="form-control @error('product_name') is-invalid @enderror" value="{{ $product->product_name }}" name="product_name" id="name" type="text" placeholder="Product name">
                                        @error('product_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3 mb-3">
                                    <div class="form-group">
                                        <label for="number">Number</label> 
                                        <input class="form-control @error('police_number') is-invalid @enderror" value="{{ $product->police_number }}" id="number" name="police_number" placeholder="No.">
                                        @error('police_number')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Price <span class="text-danger">*</span></label>
                                <input type="text" name="price" value="{{ $product->price }}" class="@error('price') is-invalid @enderror form-control">
                                @error('price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6 col-xl-6">
                                    <div class="mb-3">
                                        <label >Merk </label>
                                        <input name="merk" value="{{ $product->merk }}" class="@error('merk') is-invalid @enderror form-control" type="text" placeholder="" >
                                        @error('merk')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-xl-6">
                                    <div class="mb-3">
                                        <label >Type </label>
                                        <input name="type" value="{{ $product->type }}" class="@error('type') is-invalid @enderror form-control" type="text" placeholder="" >
                                        @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <div class="settings-btns">
                                    <button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">Save</button>&nbsp;&nbsp;
                                    <a href="{{ route('products.index') }}" class="btn btn-secondary btn-rounded">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
            
@section('script')
    
@endsection