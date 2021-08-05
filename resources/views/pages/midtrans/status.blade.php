@extends('layouts.success')

@section('title')
Khairina Store - Jual Pakaian Wanita 
@endsection

@section('content')
@if ($db->status_pay == 'PENDING')
<div class="page-content page-success">
  <div class="section-success" data-aos="zoom-in">
    <div class="container">
      <div class="row align-items-center row-login justify-content-center">
        <div class="col-lg-6 text-center">
          <img src="/images/success-1.svg" alt="" class="mb-4" />
          <h2>Transaction Failed!</h2>
          <p>
            Maaf transaksi yang anda lakukan gagal coba ulang kembali!
          </p>
          <div>
            <a href="{{ route('dashboard') }}" class="btn btn-success w-50 mt-4"style="border-radius:20px">
              My Dashboard</a
            >
            <a href="{{ route('home')}}" class="btn btn-signup w-50 mt-2"style="border-radius:20px">
              Go to Shopping</a 
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@elseif ($db->status_pay == 'SUCCESS')
<div class="page-content page-success">
  <div class="section-success" data-aos="zoom-in">
    <div class="container">
      <div class="row align-items-center row-login justify-content-center">
        <div class="col-lg-6 text-center">
          <img src="/images/success-1.svg" alt="" class="mb-4" />
          <h2>Transaction Processed!</h2>
          <p>
            Silahkan tunggu konfirmasi email dari kami dan kami akan
            menginformasikan resi secepat mungkin!
          </p>
          <div>
            <a href="{{ route('dashboard') }}" class="btn btn-success w-50 mt-4"style="border-radius:20px">
              My Dashboard</a
            >
            <a href="{{ route('home')}}" class="btn btn-signup w-50 mt-2"style="border-radius:20px">
              Go to Shopping</a 
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@else
<div class="page-content page-success">
  <div class="section-success" data-aos="zoom-in">
    <div class="container">
      <div class="row align-items-center row-login justify-content-center">
        <div class="col-lg-6 text-center">
          <img src="/images/success-1.svg" alt="" class="mb-4" />
          <h2>Transaction Expired!</h2>
          <p>
            Silahkan Order kembali, Happy Shopping!
          </p>
          <div>
            <a href="{{ route('dashboard') }}" class="btn btn-success w-50 mt-4"style="border-radius:20px">
              My Dashboard</a
            >
            <a href="{{ route('home')}}" class="btn btn-signup w-50 mt-2"style="border-radius:20px">
              Go to Shopping</a 
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endif
@endsection