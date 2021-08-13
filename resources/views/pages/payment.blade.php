@extends('layouts.app')
   
@section('title')
    Khairina Store - Jual Pakaian Wanita    
@endsection

@section('content')
<div class="page-content page-cart">
  <section class="store-breadcrumbs" data-aos="fade-down" data-aos-delay="100">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="/index.html">Home</a>
              </li>
              <li class="breadcrumb-item active">
                Cart
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </section>

<section class="store-cart">
  <div class="container">
    <div class="row" data-aos="fade-up" data-aos-delay="100">
      <div class="col-12 table-responsive">
        <table class="table table-borderless table-cart">
          <thead>
            <tr>
                <td>Image</td>
                <td>Name</td>
                <td>Quantity</td>
                <td>Price</td>
                <td>Menu</td>
            </tr>
              </thead>
              <tbody>
                @php $totalPrice = 0 @endphp
              @foreach ($carts as $index => $cart) 
                <tr>
                  <td style="width: 25%;">
                    @if ($cart->product->galleries)
                      <img src="{{ Storage::url($cart->product->galleries->first()->photos) }}" 
                    alt=""
                    class="cart-image">
                    @endif
                  </td>
                    <td style="width: 35%;">
                      <div class="product-title items">{{ $cart->product->name }}</div>
                    </td>
                    <td style="width: 35%;">
                        <form action="#">
                            <div class="quantity">
                                <button type="button" data-quantity="minus" data-field="quantity{{  $index }}" data-stock="{{ $cart->product->stock }}" data-productId="{{ $cart->id }}" data-productPrice="{{ $cart->product->price }}"><i class="fas fa-minus"></i></button>
                                <input type="number" name="quantity{{  $index }}" id="quantity{{  $index }}" value="{{  $cart->quantity }}"  data-stock="{{ $cart->product->stock }}" data-productId="{{ $cart->id }}" data-productPrice="{{ $cart->product->price }}"/>
                                <button type="button" data-quantity="plus" data-field="quantity{{  $index }}" data-stock="{{ $cart->product->stock }}" data-productId="{{ $cart->id }}" data-productPrice="{{ $cart->product->price }}"><i class="fas fa-plus"></i></button>
                            </div>
                        </form>
                    </td>
                    <td style="width: 35%;">
                      <div class="product-title" id="productPrice{{ $index }}">{{ $cart->product->price }}</div>
                      <div class="product-subtitle">IDR</div>
                    </td>
                    <td style="width: 20%;">
                      <form action="{{ route('cart-delete', $cart->id) }}" method="POST">
                      @method('DELETE')
                      @csrf
                        <button type="submit" class="btn btn-remove-cart">
                        X
                      </button>
                    </form>
                </td>
              </tr>
              @php
                  $totalPrice += $cart->product->price
              @endphp
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
    <div class="row" data-aos="fade-up" data-aos-delay="150">
      <div class="col-12">
        <h2 class="mb-4">Shipping Details</h2>
    <form action="{{ route('checkout') }}" id="locations" enctype="multipart/form-data" method="POST">
      @csrf
      <input type="hidden" name="total_price" value="{{ $totalPrice }}">
      <div class="row mb-2" data-aos="fade-up" data-aos-delay="200">
        <div class="col-md-6">
            <div class="form-group">
              <label for="address_one">Address 1</label>
              <input 
              type="text" 
              class="form-control" 
              id="address_one" 
              name="address_one" 
              value=" ">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="provinces_id">Province</label>
                <select name="provinces_id" id="provinces_id" class="form-control" v-if="provinces" v-model="provinces_id">
                  <option v-for="province in provinces" :value="province.id">@{{ province.province }}</option>
                </select>
            <select v-else class="form-control"></select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="regencies_id">City</label>
                  <select name="regencies_id" id="regencies_id" class="form-control" v-if="regencies" v-model="regencies_id">
                  <option v-for="regency in regencies" :value="regency.id">@{{ regency.city_name }}</option>
                </select>
            <select v-else class="form-control"></select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="zip_code">Postal Code</label>
              <input 
              type="text" 
              class="form-control" 
              id="zip_code" 
              name="zip_code" 
              value="">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="country">Country</label>
              <input 
              type="text" 
              class="form-control" 
              id="country" 
              name="country" 
              value="Indonesia">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="phone_number">Mobile</label>
              <input 
              type="number" 
              class="form-control" 
              id="phone_number" 
              name="phone_number">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Delivery Service</label>
                <select name="couriers" id="couriers" class="form-control" v-model="courierName">
                  <option>Pilih Kurir</option>
                  <option value="jne">JNE</option>
                  <option value="tiki">TIKI</option>
                  <option value="pos">POS Indonesia</option>
                </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="country">Service</label>
                <select name="services" id="services" class="form-control" v-if="services" v-model="services">
                  <option v-for="service in services" :value="service">@{{ service.service }}</option>
                </select>
            <select v-else class="form-control"></select>
            </div>
          </div>
        </div>
        <div class="row" data-aos="fade-up" data-aos-delay="150">
          <div class="col-12">
          <hr />
          </div>
          <div class="col-12">
            <h2 class="mb-1">Payment Informations</h2>
          </div>
        </div>
      <div class="row" data-aos="fade-up" data-aos-delay="200">
       <!-- <div class="col-4 col-md-2">
          <div class="product-title">Rp0</div>
          <div class="product-subtitle">Country Tax</div>
        </div>
        <div class="col-4 col-md-3">
          <div class="product-title">Rp0</div>
          <div class="product-subtitle"> Product Insurance</div>
        </div>-->
        <div class="col-4 col-md-2">
          <div class="product-title">Rp @{{ ongkir }}</div>
          <div class="product-subtitle">Ship to Jakarta</div>
        </div>
        <div class="col-4 col-md-2">
          <div class="product-title text-success" id="totalBiaya">Rp.{{ number_format($totalPrice ?? 0)  }}</div>
          <div class="product-subtitle">Total</div>
        </div>
        <div class="col-8 col-md-3">
          <input type="hidden" name="ongkir" v-model="ongkir">
          <button 
          type="submit"  
          class="btn btn-success mt-4 px-4 btn-block"style="border-radius:20px">
          Checkout Now
            </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
@push('addon-script')
<script src="/vendor/vue/vue.js"></script>
<script src="https://unpkg.com/vue-toasted"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
script>
    var locations =  new Vue({
    el:"#locations",
    mounted() {
      AOS.init();
      this.getProvincesData();
    },
    data: {
        provinces: null,
        regencies:null,
        provinces_id:null,
        regencies_id:null,
        courierName: null,
        services: null,
        ongkir: 0
    },
    methods: {
        getProvincesData() {
          var self = this;
              axios.get('{{ route('api-provinces') }}')
              .then(function(response){
              self.provinces = response.data;
            })
          },
          getRegenciesData(){
            var self = this;
            // tadi variabel self ga ada
              axios.get('{{ url('api/cities') }}/' + this.provinces_id)
              .then(function(response){
              self.regencies = response.data;
            })
          },
          getCourier(){
            var self = this;
            data = {
              destination: this.regencies_id,
              courier: this.courierName
            }
            axios.post('{{ url('api/ongkir') }}', data).then(function(res) {
              self.services = res.data
            })
          }
        },
       watch: {
         provinces_id: function(val, oldVal){
            this.provinces_id = val;
            this.regencies_id = null;
            this.getRegenciesData();
            
         },
         courierName: function(val) {
           if (val !== "Pilih Kurir") {
              this.courierName = val
              this.getCourier()
           }
         },
         services: function(val) {
           this.ongkir = val.cost[0].value
         }
       }
      }); 
</script>

script>
  jQuery(document).ready(function() {
    let totalBiayaValue = 0;
    const jumlahItems = document.querySelectorAll(".items");
    const totalBiaya = document.getElementById('totalBiaya')
    let productPriceShow;
    let totalHarga = 0;

    for(i = 0; i < jumlahItems.length; i++){
                    const firstQuantity = document.getElementById('quantity' + i).value
                    let hargaProduk = document.getElementById('productPrice' + i).innerHTML
                    productPriceShow = document.getElementById('productPrice' + i)
                    const firstHargaProduk = hargaProduk * firstQuantity
                    totalHarga += firstHargaProduk;
                    
                    productPriceShow.innerText = 'Rp. ' + parseFloat(hargaProduk, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString()
                    totalBiaya.innerText = 'Rp. ' + parseFloat(totalHarga, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString()
                    totalBiayaValue = totalHarga
                }

    let currenValueInput = 0;
    $("[data-formQuantity='quantity' ] ").on('focusin', function(e) {
        currenValueInput = parseInt($(this).val());
    });
    
    $("[data-formQuantity='quantity' ] ").change(function(e) {
      // ini bisa dipanggil
        let quantity = 0
        let stockBerubah = 0
        const angka = parseInt($(this).val())
        const stock = $(this).attr('data-stock');
        const hargaProduk = $(this).attr('data-productPrice');
        
        if (angka > stock){
            quantity = stock
            $(this).val(stock)
            $('input[name=quantity]').val(quantity);
        } else {
            quantity = angka
            $('input[name=quantity]').val(quantity);
        }
        // Update Produk Price
        if (currenValueInput < quantity) {
            updateHarga = hargaProduk * (quantity - currenValueInput)
            totalHarga += updateHarga;
        } else {
            updateHarga = hargaProduk * (currenValueInput - quantity)
            totalHarga -= updateHarga;
        }
        subTotal.innerText = 'Rp. ' + parseFloat(totalHarga, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString()
        totalBiaya.innerText = 'Rp. ' + parseFloat(totalHarga, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString()
        totalBiayaValue = totalHarga

        // Update quantity 
        let productId = $(this).attr('data-productId');
        let CSRFToken = '{{ csrf_token() }}'
        $.ajax({
            url: `cart/${productId}`,
            type: 'post',
            data: {
                _token: CSRFToken,
                quantity: quantity
            },
        });
    });

    // This button will increment the value
    $("[data-quantity='plus' ] ").click(function(e) {
        const hargaProduk = $(this).attr('data-productPrice');
        let quantity;
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('data-field');
        // Get stock
        stock = $(this).attr('data-stock');
        // Get its current value
        var currentVal = parseInt($('input[name=' + fieldName + ']').val());
        // If is not undefined
        if (!isNaN(currentVal)) {
            // Increment
            quantity = currentVal + 1;
            if (quantity > stock) {
                quantity = stock
            }
            $('input[name=' + fieldName + ']').val(quantity);
        } else {
            // Otherwise put a 0 there
            quantity = 0;
            $('input[name=' + fieldName + ']').val(quantity);
        }
        // Update Produk Price
        updateHarga = hargaProduk * (quantity - currentVal )
        totalHarga += updateHarga;
        totalBiaya.innerText = 'Rp. ' + parseFloat(totalHarga, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString()
        totalBiayaValue = totalHarga

        // Update quantity 
        let productId = $(this).attr('data-productId');
        let CSRFToken = '{{ csrf_token() }}'
        $.ajax({
            url: `cart/${productId}`,
            type: 'post',
            data: {
                _token: CSRFToken,
                quantity: quantity
            },
        });
    });
    // This button will decrement the value till 0
    $("[data-quantity='minus' ] ").click(function(e) {
        const hargaProduk = $(this).attr('data-productPrice');
        let quantity;
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('data-field');
        // Get its current value
        var currentVal = parseInt($('input[name=' + fieldName + ']').val());
        // If it isn't undefined or its greater than 0
        if (!isNaN(currentVal) && currentVal > 0) {
            // Decrement one
            quantity = currentVal - 1;
            $('input[name=' + fieldName + ']').val(quantity);
        } else {
            // Otherwise put a 0 there
            quantity = 0;
            $('input[name=' + fieldName + ']').val(quantity);
        }
        updateHarga = hargaProduk * (currentVal - quantity)
        totalHarga -= updateHarga;
        totalBiaya.innerText = 'Rp. ' + parseFloat(totalHarga, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString()
        totalBiayaValue = totalHarga

        // Update quantity 
        let productId = $(this).attr('data-productId');
        let CSRFToken = '{{ csrf_token() }}'
        $.ajax({
            url: `cart/${productId}`,
            type: 'post',
            data: {
                _token: CSRFToken,
                quantity: quantity
            },
        });
    });
  });
</script>
@endpush