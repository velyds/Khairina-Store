@extends('layouts.app')

@section('title')
    Khairina Store - Jual Pakaian Wanita    
@endsection

@section('content')
<div class="page-content page-home"></div>
  <section class="banner-bottom-wthreelayouts py-lg-5 py-3">
    <div class="container">
      <div class="row">
        <div class="col-12" data-aos="fade-up">
          <div class="inner_sec">
          <h3 class="tittle-contact text-center mb-lg-5 mb-3">Contact</h3>
              <div class="address row" style="position:relative">
                <div class="col-lg-6 address-grid">
                  <div class="row address-info">
                    <div class="col-md-3 address-left text-center">
                      <em class="far fa-map"></em>
                    </div>
                    <div class="col-md-9 address-right text-left">
                      <h6>Address</h6>
                      <p>Padang, Indonesia</p>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 address-grid">
                  <div class="row address-info">
                    <div class="col-md-3 address-left text-center">
                      <em class="fas fa-mobile-alt"></em>
                    </div>
                    <div class="col-md-9 address-right text-left">
                      <h6>Whatsapp</h6>
                      <p>+62 81212954781</p>
                    </div>
                  </div>
                </div>
              </div>
              <!-- batas -->
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--map-->
    <div class="contact-map">
      <iframe
      title="map" 
      class="map"
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d255322.56435533808!2d100.40144806824229!3d-0.8146164012189157!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xbda0e2acdc14c364!2sPasa%20Pagi%20Simpang%20Ampek!5e0!3m2!1sid!2sid!4v1623687312403!5m2!1sid!2sid" 
      style="border:0;" 
      allowfullscreen="" 
      loading="lazy"></iframe>
    </div>
@endsection