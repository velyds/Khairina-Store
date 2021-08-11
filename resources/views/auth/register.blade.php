@extends('layouts.auth')

@section('content')
<div class="page-content page-auth" id="register">
    <div class="section-store-auth" data-aos="fade-up">
        <div class="container">
            <div class="row align-items-center justify-content-center row-login">
                <div class="col-lg-4"> 
                    <h2>
                        Membuat akun Anda
                    </h2>
                    <p>Kami tidak akan posting atas nama Anda </br>
                        atau membagikan informasi apapun tanpa persetujuan Anda.</p>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group"> 
                                <label>Full Name</label>
                                    <input 
                                        v-model="name" 
                                        id="name" 
                                        type="text" 
                                        class="form-control @error('name') is-invalid @enderror" 
                                        name="name" 
                                        value="{{ old('name') }}" 
                                        required 
                                        autocomplete="name"
                                        onkeydown="preventNumberInput(event)" 
                                        onkeyup="preventNumberInput(event)" 
                                        autofocus>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input 
                                    id="email"
                                    v-model="email" 
                                    @change="checkForEmailAvailability()"
                                    type="email" 
                                    class="form-control @error('email') is-invalid @enderror"
                                    :class="{ ' is-invalid' : this.email_unavailable}" 
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    required 
                                    autocomplete="email"
                                    autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            <div class="form-group">
                                <label>Password</label>     
                                    <input 
                                    id="password" 
                                    type="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    name="password" 
                                    required 
                                    autocomplete="new-password" 
                                    maxlength="13">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>     
                                 <input 
                                 id="password-confirm" 
                                 type="password" 
                                 class="form-control @error('password_confirmation') is-invalid @enderror" 
                                 name="password_confirmation" 
                                 required 
                                 autocomplete="new-password"
                                 maxlength="13">
                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                            <button
                                type="submit"
                                class="btn btn-success btn-block mt-4"
                                :disabled="this.email_unavailable"
                            >
                                Sign Up Now
                            </button>
                            <a
                                href="{{ route('login') }}" 
                                class="btn btn-signup btn-block mt-2">
                                Back to Sign In                  
                            </a>
                        </form>
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
      Vue.use(Toasted);

      var register = new Vue({
        el:'#register',
        mounted(){
          AOS.init();
        },
        methods: {
            checkForEmailAvailability: function(){
                var self = this;
                axios.get('{{ route('api-register-check') }}', {
                    params: {
                        email: this.email
                    }
                })
                .then(function (response) {

                if(response.data == 'Available'){ 
                    self.$toasted.show(
                        "Email anda tersedia silahkan lanjut langkah selanjutnya.",
                        {
                        position: "top-center",
                        className:"rounded",
                        duration: 1000,
                        }
                    );
                    self.email_unavailable= false;

                } else {
                    self.$toasted.error(
                        "Maaf, tampaknya email sudah terdaftar pada sistem kami.",
                        {
                        position: "top-center",
                        className:"rounded",
                        duration: 1000,
                        }
                    );
                    self.email_unavailable= true;
                }

                // handle success
                console.log(response);
            });
        }
    },
    data(){
        return {
            email: "example@gmail.com",
            email_unavailable:false
        }
    },
    });
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
