@extends('layouts.app')

@section('title')
    Store Detail Page   
@endsection

@section('content')
<div class="page-content page-details">
      <section class="store-breadcrumbs" data-aos="fade-down" data-aos-delay="100">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <nav>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                  </li>
                  <li class="breadcrumb-item active">
                    Product Details
                  </li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </section>

      <section class="store-gallery mb-3" id="gallery">
        <div class="container">
          <div class="row">
            <div class="col-lg-5" data-aos="zoom-in">
              <transition name="slide-fade" mode="out-in">
                <img :src="photos[activePhoto].url" :key="photos[activePhoto].id" 
                class="w-100 main-image"
                alt="">
              </transition>
              <!-- Desktop Version -->
              <div class="d-none d-lg-flex ">
                  <div class="d-inline-flex" v-for="(photo, index) in photos" :key="photo.id" data-aos="fade-up" data-aos-delay="200">
                      <a href="#" @click="changeActive(index)">
                          <img :src="photo.url" class="thumbnail-image" style="width: 191px;" :class="{ active: index == activePhoto }" alt="">
                      </a>
                  </div>
              </div>
              <!-- Mobile Version -->
              <div class="d-lg-none ">
                  <div class="d-inline-flex" v-for="(photo, index) in photos" :key="photo.id" data-aos="zoom-in" data-aos-delay="200">
                      <a href="#" @click="changeActive(index)">
                          <img :src="photo.url" class="thumbnail-image" style="width: 130px;" :class="{ active: index == activePhoto }" alt="">
                      </a>
                  </div>
              </div>
            </div>
            <div class="store-details-container col-lg-7" data-aos="fade-up">
              <section class="store-heading">
                  <h1>{{ $product->name }}</h1>
                  <div class="price">Rp.{{ number_format($product->price) }}</div>
                  <span class="quantity-title">Quantity : </span>
                      <div class="product-quantity d-flex flex-wrap align-items-center">
                          <form action="#">
                              <div class="quantity d-flex mb-3">
                                  <button type="button" data-quantity="minus" data-field="quantity"><i class="fas fa-minus"></i></button>
                                  <input type="number" id="quantity" value="1"/>
                                  <button type="button" data-quantity="plus" data-field="quantity"><i class="fas fa-plus"></i></button>
                                </div>
                          </form>
                      </div>
                  <div class="flex items-center">
                    <span class="items-center">Color : </span>
                    @php
                      $colors = explode(',', $product->colors);
                    @endphp
                    @foreach ($colors as $color)
                      <button type="button" class="btn btn-outline-dark">{{ $color }}</button>
                    @endforeach
                  </div> 
                  <section class="store-description">
                    <div class="container">
                      <div class="row">
                        <div class="store-description">
                          {!! $product->description !!}
                      </div>
                    </div>
                   </div>
                  </section>
                    @auth  
                      <form action="{{ route('detail-add', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="quantity" name="quantity" value="1">
                        <button
                          type="submit" 
                          class="btn btn-success px-4 text-white mb-3" style="border-radius:20px">
                          Add to cart
                      </button> 
                      </form>
                    @else
                    <a 
                      href="{{ route('login') }}"
                      class="btn btn-success px-4 text-white mb-3" style="border-radius:20px">
                      Sign in to add
                    </a>
                    @endauth  
              </section>
              </div>
            </div>
          </div>
        </div>
      </section>

      
    </div>
  </div>

@endsection

@push('addon-script')
<script src="/vendor/vue/vue.js"></script>
<script>
    var gallery =  new Vue({
    el:"#gallery",
    mounted() {
        AOS.init();
    },
    data: {
        activePhoto: 0,
        photos: [
          @foreach($product->galleries as $gallery)
            {
              id: {{ $gallery->id }},
              url:"{{ Storage::url($gallery->photos) }}",
            },
          @endforeach
        ],
    },
    methods: {
        changeActive(id) {
        this.activePhoto = id;
        }
    }
    });
</script> 
 <script>
    const stock = '{{ $product->stock }}'
    jQuery(document).ready(function() {
        let quantity = 0;
        // This button will increment the value
        $('[data-quantity="plus"]').click(function(e) {
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            fieldName = $(this).attr('data-field');
            // Get its current value
            var currentVal = parseInt($('input[id=' + fieldName + ']').val());
            // If is not undefined
            if (!isNaN(currentVal)) {
                // Increment
                quantity = currentVal + 1;
                if (quantity > stock){
                    quantity = stock
                }
                $('input[id=' + fieldName + ']').val(quantity);
                $('input[name=' + fieldName + ']').val(quantity);
            } else {
                // Otherwise put a 0 there
                $('input[id=' + fieldName + ']').val(0);
                $('input[name=' + fieldName + ']').val(0);
            }
        });
        // This button will decrement the value till 0
        $('[data-quantity="minus"]').click(function(e) {
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            fieldName = $(this).attr('data-field');
            // Get its current value
            var currentVal = parseInt($('input[id=' + fieldName + ']').val());
            // If it isn't undefined or its greater than 0
            if (!isNaN(currentVal) && currentVal > 0) {
                // Decrement one
                quantity = currentVal - 1;
                $('input[id=' + fieldName + ']').val(quantity);
                $('input[name=' + fieldName + ']').val(quantity);
            } else {
                // Otherwise put a 0 there
                $('input[id=' + fieldName + ']').val(0);
                $('input[name=' + fieldName + ']').val(0);
            }
        });
    });
    $("#quantity").change(function() {
        const angka = parseInt($(this).val())
        
        if (angka > stock){
            $(this).val(stock)
            $('input[name=quantity]').val(stock);
        } else {
            $('input[name=quantity]').val(angka);
        }
    });
</script>
@endpush