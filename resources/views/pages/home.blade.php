@extends('layouts.app')

@section('title')
    Khairina Store - Jual Pakaian Wanita    
@endsection

@section('content')
<div class="page-content page-home">
    <section class="store-carousel">
        <div class="container">
            <div class="row">
            <div class="col-lg-12" data-aos="zoom-in">
                <div id="storeCarousel" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#storeCarousel" data-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></li>
                    <li data-target="#storeCarousel" data-slide-to="1" aria-label="Slide 2"></li>
                    <li data-target="#storeCarousel" data-slide-to="2" aria-label="Slide 3"></li>
                </ol>
                <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="/images/banner1.png" class="d-block w-100" alt="Carousel Image">
                        <div class="carousel-caption d-none d-md-block">
                        </div>
                    </div>
                        <div class="carousel-item">
                            <img src="/images/banner2.png" class="d-block w-100" alt="Carousel Image">
                        <div class="carousel-caption d-none d-md-block">
                        </div>
                    </div>
                        <div class="carousel-item">
                            <img src="/images/banner3.png" class="d-block w-100" alt="Carousel Image">
                        <div class="carousel-caption d-none d-md-block">
                        </div>
                    </div>
                </div>
                </div>
                <a class="carousel-control-prev" data-target="#storeCarousel" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </a>
                <a class="carousel-control-next" data-target="#storeCarousel" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </a>
                </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </section>

<!--<section class="store-trend-categories">
      <div class="container my-4">
        <div class="row">
          @php
            $incrementCategory = 0
          @endphp
          @forelse ($categories as  $category)
            <div
            class="col-6 col-md-3 col-lg-2"
            data-aos="fade-up"
            data-aos-delay="{{ $incrementCategory+= 100 }}"
          >
            <a href="{{ route('categories', $category->slug) }}" class="component-categories d-block">
              <div class="categories-image">
                <img 
                  src="{{ Storage::url($category->photo) }}" 
                  alt="" 
                  class="w-100" />
              </div>
              <p class="categories-text">
                {{ $category->name }}
              </p>
            </a>
          </div>
          @empty
        <div class="col-12 text-center py-5"
              data-aos="fade-us"
              data-aos-delay="100">
              No Category Found
        </div>
      @endforelse
    </div>
  </div>
</section>-->

<section class="store-new-product">
    <div class="container">
        <div class="row">
        <div class="col-12" data-aos="fade-up">
            <h4 class="text-center" style="margin-top: 35px; margin-bottom:35px">Top Searches This Week</h4>
        </div>
            </div>
        <div class="row">
            @php
                    $incrementProduct = 0
            @endphp
            @forelse ($products as $product )
                <div
                    class="col-6 col-md-4 col-lg-3"
                    data-aos="fade-up"
                    data-aos-delay="{{ $incrementProduct+= 100 }}"
                >
                    <a href="{{ route('detail', $product->slug) }}" class="component-products d-block">
                        <div class="products-thumbnail">
                            <div
                            class="products-image"
                            style="
                                @if ($product->galleries->count())
                                    background-image:url('{{ Storage::url($product->galleries->first()->photos) }}')
                                @else
                                    background-color:#eee
                                @endif
                            "
                            ></div>
                        </div>
                        <div class="products-text">
                            {{ $product->name }}
                        </div>
                        <div class="products-price">
                            @rupiah($product->price)
                        </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center py-5"
                        data-aos="fade-us"
                        data-aos-delay="100">
                        No Product Found
                    </div>
                @endforelse
            </div>
        </div>
    </section>

<section class="testimonial">
    <div class="container">
    <div class="row">
    <div class="col-12" data-aos="zoom-in">
        <div class="testimonials py-lg-4 py-3 mt-4">
            <div class="testimonials-inner py-lg-4 py-3">
            <h3 class="text-center my-lg-4 my-4">
                Testimonials
            </h3>
            <div
                id="carouselExampleControls"
                class="carousel slide"
                data-ride="carousel"
            >
                <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <div class="testimonials_grid text-center">
                    <h3>
                        Anamaria
                        <span>Customer</span>
                    </h3>
                    <label>Tangerang</label>
                    <p>
                        Bagus banget blousenya🤩🤩 Bahannya nyaman banget di pake
                        Ukurannya pas, Recommended
                    </p>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="testimonials_grid text-center">
                    <h3>
                        Esmeralda
                        <span>Customer</span>
                    </h3>
                    <label>Padang</label>
                    <p>
                        Barang sudah sampai sesuai pesanan, packing aman 
                        pengiriman cepat, produk saya suka terimakasih 😁
                    </p>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="testimonials_grid text-center">
                    <h3>
                        Afifah
                        <span>Customer</span>
                    </h3>
                    <label>Tangerang</label>
                    <p>
                        Bahannya adem , Recommended bgt pokoknya saya
                        suka Pengiriman juga cepat
                    </p>
                    </div>
                </div>
                <a
                    class="carousel-control-prev test"
                    href="#carouselExampleControls"
                    role="button"
                    data-slide="prev"
                >
                    <span class="fas fa-long-arrow-alt-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a
                    class="carousel-control-next test"
                    href="#carouselExampleControls"
                    role="button"
                    data-slide="next"
                >
                    <span
                    class="fas fa-long-arrow-alt-right"
                    aria-hidden="true"
                    ></span>
                    <span class="sr-only">Next</span>
                </a>
                </div>
            </div>
            </div>
        </div>
        
    <!-- /clients-sec -->
   <div class="testimonials p-lg-5 p-3 mt-4">
    <div class="row last-section" >
        <div class="col-lg-3 footer-top-w3layouts-grid-sec">
        <div class="mail-grid-icon text-center">
            <i class="fas fa-gift"></i>
        </div>
        <div class="mail-grid-text-info">
            <h3>Genuine Product</h3>
            <p>Stylish and Fashionable Appearance</p>
        </div>
        </div>
        <div class="col-lg-3 footer-top-w3layouts-grid-sec">
        <div class="mail-grid-icon text-center">
            <i class="fas fa-shield-alt"></i>
        </div>
        <div class="mail-grid-text-info">
            <h3>Secure Products</h3>
            <p>Safe Product Packaging</p>
        </div>
        </div>
        <div class="col-lg-3 footer-top-w3layouts-grid-sec">
        <div class="mail-grid-icon text-center">
            <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="mail-grid-text-info">
            <h3>Payment</h3>
            <p>Bank and GOPAY</p>
        </div>
        </div>
        <div class="col-lg-3 footer-top-w3layouts-grid-sec">
        <div class="mail-grid-icon text-center">
            <i class="fas fa-truck"></i>
        </div>
        <div class="mail-grid-text-info">
            <h3>Easy Delivery</h3>
            <p>JNE | TIKI | </br>
                Pos Indonesia</p>
                    </div>
                </div>
            </div>
        </div>
         <div class="p-lg-5 p-2 mt-2">
         </div>
    </section>
</div>
@endsection