@extends('layouts.admin')

@section('title')
    Dashboard Product
@endsection
 
@section('content')
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
        <h2 class="dashboard-title">Product</h2>
            <p class="dashboard-subtitle">
            Create New Product
            </p>
            </div> 
        <div class="dashboard-content" id="createProduct">
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
                                <form action="{{ route('product.store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Nama Produk</label>
                                                <input type="text" name="name" class="form-control" onkeydown="preventNumberInput(event)" 
                                                onkeyup="preventNumberInput(event)" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Kategori Produk</label>
                                                <select name="categories_id" class="form-control">
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                         <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Stok produk</label>
                                                <input type="number" name="stock" class="form-control" v-model="stock" v-on:input="updateStok" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Harga Produk</label>
                                                <input type="number" name="price" class="form-control" v-model="harga" v-on:input="updateHarga" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Deskripsi Produk</label>
                                                <textarea name="description" id="editor" ></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-right">
                                            <button type="submit" class="btn btn-success px-5">
                                                Save Now
                                            </button>
                                        </div>
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

@push('addon-script')
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <script src="/vendor/vue/vue.js"></script>
    <script>
      var createProduct = new Vue ({
        el: '#createProduct',
          data: {
            stock: 0,
            harga: 0,
          },
          methods: {
              updateStok(e) {
                  const value = e.target.value
                  if (value >= 999) {
                      this.stock = 999
                  }
              },
              updateHarga(e) {
                  const value = e.target.value
                  if (value >= 999999999) {
                      this.harga = 999999999
                  }
              },
          }
      });
    </script>
    <script>
            CKEDITOR.replace('editor');
    </script>
    <script>
    function preventNumberInput(e) {
      var keyCode = (e.keyCode ? e.keyCode : e.which);
      if (keyCode > 47 && keyCode < 58 || keyCode > 95 && keyCode < 107) {
        e.preventDefault();
      }
    }
    $(document).ready(function() {
      $('#text_field').keypress(function(e) {
        preventNumberInput(e);
      });
    })
    </script>  
@endpush
