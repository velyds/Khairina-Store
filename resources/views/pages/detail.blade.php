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
            <div class="col-lg-6" data-aos="zoom-in">
              <transition name="slide-fade" mode="out-in">
                <img :src="photos[activePhoto].url" :key="photos[activePhoto].id" 
                class="w-100 main-image"
                alt="">
              </transition>
            </div>
            <div class="col-lg-2">
              <div class="row">
                <div class="col-3 col-lg-12 mt-2 mt-lg-0" v-for="(photo, index) in photos"
                :key="photo.id" data-aos="zoom-in" data-aos-delay="100">
                  <a href="#" @click="changeActive(index)">
                    <img :src="photo.url" 
                      class="w-100 thumbnail-image" 
                      :class="{active: index == activePhoto}"
                      alt="">
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <div class="store-details-container" data-aos="fade-up">
        <section class="store-heading">
          <div class="container">
            <div class="row">
              <div class="col-lg-6"> 
                <h1>{{ $product->name }}</h1>
                <div class="price">Rp.{{ number_format($product->price) }}</div>
                <span class="quantity-title">Quantity: </span>
                    <div class="product-quantity d-flex flex-wrap align-items-center">
                        <form action="#">
                            <div class="quantity d-flex mb-3">
                                <button type="button" data-quantity="minus" data-field="quantity"><i class="fas fa-minus"></i></button>
                                <input type="number" id="quantity" value="1"/>
                                <button type="button" data-quantity="plus" data-field="quantity"><i class="fas fa-plus"></i></button>
                            </div>
                        </form>
                    </div>
              </div>
              <div class="col-lg-2" data-aos="zoom-in">
                @auth  
                  <form action="{{ route('detail-add', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="quantity" name="quantity" value="1">
                    <button
                      type="submit" 
                      class="btn btn-success px-4 text-white btn-block mb-3" style="border-radius:20px">
                      Add to cart
                   </button> 
                  </form>
                @else
                <a 
                  href="{{ route('login') }}"
                  class="btn btn-success px-4 text-white btn-block mb-3" style="border-radius:20px">
                  Sign in to add
                </a>
                @endauth
              </div>
            </div>
          </div>
        </section>
        <section class="store-description">
          <div class="container">
            <div class="row">
              <div class="col-12 col-lg-8">
                {!! $product->description !!}
            </div>
          </div>
        </div>
      </div>
    </section>
  
        <!--<section class="store-review">
          <div class="container">
            <div class="row">
              <div class="col-12 col-lg-8 mt-3 mb-3">
                <h5>Customer Review (3)</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-lg-8">
                <ul class="list-unstyled">
                  <li class="media">
                    <img src="/images/icon-testimonial-1.png" alt="" class="mr-3 rounded-circle">
                    <div class="media-body">
                      <h5 class="mt-2 mb-1">Hazza Risky</h5>
                      I thought it was not good for living room. I really happy
                      to decided buy this product last week now feels like homey.
                    </div>
                  </li>
                  <li class="media">
                    <img src="/images/icon-testimonial-2.png" alt="" class="mr-3 rounded-circle">
                    <div class="media-body">
                      <h5 class="mt-2 mb-1">Anna Sukkirata</h5>
                      Color is great with the minimalist concept. Even I thought it was
                      made by Cactus industry. I do really satisfied with this.
                    </div>
                  </li>
                  <li class="media">
                    <img src="/images/icon-testimonial-3.png" alt="" class="mr-3 rounded-circle">
                    <div class="media-body">
                      <h5 class="mt-2 mb-1">Selena Gomez</h5>
                      When I saw at first, it was really awesome to have with.
                      Just let me know if there is another upcoming product like this.
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </section>-->
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