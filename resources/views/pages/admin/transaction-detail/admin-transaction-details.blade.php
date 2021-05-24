{{-- bener --}}
@extends('layouts.admin')

@section('title')
    Khairina Store - Jual Fashion Wanita    
@endsection

@section('content')
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">#{{ $transactions->code }}</h2>
                <p class="dashboard-subtitle">
                Transactions / Details
                </p>
                </div>
                <div class="dashboard-content" id="transactionDetails">
                    <div class="row">
                        <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                <img 
                                    src="{{ Storage::url($transactions->product->galleries->first()->photos ?? '') }}" 
                                    class="w-100 mb-3" 
                                    alt="foto"
                                />
                                </div>
                                <div class="col-12 col-md-8">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="product-title">Customer Name</div>
                                                <div class="product-subtitle">{{ $transactions->transaction->user->name }}</div>
                                            </div>
                                        <div class="col-12 col-md-6">
                                            <div class="product-title">Product Name</div>
                                                <div class="product-subtitle">{{ $transactions->product->name }}</div>
                                            </div>
                                        <div class="col-12 col-md-6">
                                            <div class="product-title">Date of Transaction</div>
                                                <div class="product-subtitle">{{ $transactions->created_at }}</div>
                                            </div>
                                        <div class="col-12 col-md-6">
                                            <div class="product-title">Payment Status</div>
                                                <div class="product-subtitle text-danger">{{ $transactions->transaction->transaction_status}}</div>
                                            </div>
                                        <div class="col-12 col-md-6">
                                            <div class="product-title">Total Amount</div>
                                                <div class="product-subtitle">Rp.{{ number_format($transactions->transaction->total_price) }}</div>
                                            </div>
                                        <div class="col-12 col-md-6">
                                            <div class="product-title">Mobile</div>
                                                <div class="product-subtitle">{{ $transactions->transaction->user->phone_number}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <form action="{{ route('transaction.update', $transactions->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                                <div class="row">
                                    <div class="col-12 mt-4">
                                        <h5>Shipping Infomation</h5>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Address I</div>
                                                    <div class="product-subtitle">{{ $transactions->transaction->user->address_one }}</div>
                                                </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Address II</div>
                                                    <div class="product-subtitle">{{ $transactions->transaction->user->address_two }}</div>
                                                </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Province</div>
                                                    <div class="product-subtitle">
                                                        {{ App\Models\Province::find($transactions->transaction->user->provinces_id)->province }}
                                                    </div>
                                                </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">City</div>
                                                    <div class="product-subtitle">
                                                        {{ App\Models\City::find($transactions->transaction->user->regencies_id)->city_name }}
                                                    </div>
                                                </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Postal Code</div>
                                                <div class="product-subtitle">{{ $transactions->transaction->user->zip_code }}</div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Country</div>
                                                <div class="product-subtitle">{{ $transactions->transaction->user->country }}</div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Mobile</div>
                                                <div class="product-subtitle">{{ $transactions->transaction->user->phone_number }}</div>
                                            </div>
                                        </div> 
                                        <div class="col-12 col-md-3">
                                                <div class="product-title">Shipping Status</div>
                                                <select name="shipping_status" class="form-control">
                                                    <option value="PENDING" {{ $transactions->transaction->transaction_status == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                                                    <option value="SHIPPING" {{ $transactions->transaction->transaction_status == 'SHIPPING' ? 'selected' : '' }}>SHIPPING</option>
                                                    <option value="SUCCESS" {{ $transactions->transaction->transaction_status == 'SUCCESS' ? 'selected' : '' }}>SUCCESS</option>
                                                </select>
                                        </div>
                                            <template v-if="status == 'SHIPPING'">
                                                <div class="col-md-3">
                                                    <div class="product-title">Input Resi</div>
                                                    <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    name="resi"
                                                    v-model="resi"
                                                    />
                                                </div>
                                            <div class="col-md-2">
                                                    <button 
                                                    type="submit" 
                                                    class="btn btn-success btn-block mt-4"
                                                    >Update Resi
                                                    </button>
                                                </div>
                                            </template>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12 text-right">
                                        <button 
                                        type="submit" 
                                        class="btn btn-success btn-lg mt-4"
                                        > 
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
        </div>
    </div>
</div>
@endsection

@push('addon-script')
  <script src="/vendor/vue/vue.js"></script>
    <script>
      var transactionDetails = new Vue ({
        el: '#transactionDetails',
          data: {
            status: 'SHIPPING',
            resi: 'TGR023456342',
          },
      });
    </script> 
@endpush 