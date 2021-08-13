@extends('layouts.dashboard')

@section('title')
    Khairina Store - My Account    
@endsection

@section('content')
<div class="section-content section-dashboard-home" data-aos="fade-up">
<div class="container-fluid">
    <div class="dashboard-heading">
    <h2 class="dashboard-title">My Account</h2>
@if ($message = Session::get('alamat'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <strong>{{ $message }}</strong>
</div>
@endif
        <p class="dashboard-subtitle">
            Update your current profile
        </p>
        </div>
        <div class="dashboard-content">
        <div class="row">
            <div class="col-12">
            <form action="{{ route('dashboard-account-redirect','dashboard-account') }}" method="POST" enctype="multipart/form-data" id="locations">
                @csrf
                <div class="card">
                <div class="card-body">
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="name">Your Name</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="name" 
                            name="name"
                            onkeydown="preventNumberInput(event)" 
                            onkeyup="preventNumberInput(event)" 
                            value="{{ $user->name }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="email">Your Email</label>
                        <input 
                            type="email" 
                            class="form-control" 
                            id="email" 
                            name="email"
                            autofocus 
                            value="{{ $user->email }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="address_one">Address</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="address_one" 
                            name="address_one"
                            placeholder=" " 
                            value="{{ $user->address_one }}">
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
                            type="number" 
                            class="form-control" 
                            id="zip_code" 
                            name="zip_code"
                            onkeypress="return nomorPostalCode(event)"
                            value="{{ $user->zip_code }}">
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
                            maxlength="15"
                            onkeydown="preventNumberInput(event)" 
                            onkeyup="preventNumberInput(event)" 
                            value="Indonesia">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone_number">Mobile</label>
                            <input 
                            type="text" 
                            class="form-control" 
                            id="phone_number" 
                            name="phone_number"
                            onkeypress="return nomorTelepon(event)"
                            value="{{ $user->phone_number }}">
                        </div>
                    </div>
                </div>
                    <div class="row">
                        <div class="col text-right">
                        <button 
                            type="submit" 
                            class="btn btn-success px-5"
                            >
                            Save Now
                        </button>
                        </div>
                    </div>
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
<script src="/vendor/vue/vue.js"></script>
<script src="https://unpkg.com/vue-toasted"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    var locations =  new Vue({
    el:"#locations",
    mounted() {
      AOS.init();
      this.getProvincesData();
    },
    data: {
        provinces: null,
        regencies:null,
        provinces_id: '{{ $user->provinces_id }}' || null,
        regencies_id: '{{ $user->regencies_id }}' || null,
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
                self.getRegenciesData()
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
           console.log(val.cost[0].value)
           console.log("Tes")
         }
       }
      });
</script> 

<script>
    function preventNumberInput(e) {
      var keyCode = (e.keyCode ? e.keyCode : e.which);
      if (keyCode > 47 && keyCode < 58 || keyCode > 95 && keyCode < 107) {
        e.preventDefault();
      }
    }
    function nomorTelepon(e) {
        const nt = document.getElementById("phone_number").value

        if (nt.length >= 13) {
            return false
        }

        e = e ? e : window.event;
        let keyCode = e.which ? e.which : e.keyCode
        if (keyCode > 31 && (keyCode < 48 || keyCode > 57)) return false
        return true
    }
    $(document).ready(function() {
      $('#text_field').keypress(function(e) {
        preventNumberInput(e);
      });
    })
</script> 
<script>
    function preventNumberInput(e) {
      var keyCode = (e.keyCode ? e.keyCode : e.which);
      if (keyCode > 47 && keyCode < 58 || keyCode > 95 && keyCode < 107) {
        e.preventDefault();
      }
    }
    function nomorPostalCode(e) {
        const nt = document.getElementById("zip_code").value

        if (nt.length >= 5) {
            return false
        }

        e = e ? e : window.event;
        let keyCode = e.which ? e.which : e.keyCode
        if (keyCode > 31 && (keyCode < 48 || keyCode > 57)) return false
        return true
    }
    $(document).ready(function() {
      $('#text_field').keypress(function(e) {
        preventNumberInput(e);
      });
    })
</script>   
@endpush