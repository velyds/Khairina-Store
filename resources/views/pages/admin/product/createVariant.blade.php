@extends('layouts.admin')

@section('title')
Dashboard Product
@endsection

@section('content')
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">Product Variant</h2>
            <p class="dashboard-subtitle">
                Create New Product Variant
            </p>
        </div>
        <div class="dashboard-content">
            <div class="row">
                <div class="col-md-12">
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('storeVariant')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="products_id" value="{{ $product->id }}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Nama Produk</label>
                                            <input type="text" name="product_name" class="form-control" value="{{ $product->name }}" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label>Warna</label>
                                            <input type="text" name="color" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Keterangan</label>
                                            <textarea name="description" cols="30" rows="10" class="form-control"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Foto Produk</label>
                                            <input type="file" name="photos" class="form-control" required>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-success px-5">
                                            Save Now
                                        </button>

                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection