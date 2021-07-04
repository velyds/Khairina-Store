@extends('layouts.dashboard')

@section('title')
    Khairina Store - Transaction Detail  
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

                                {{-- Products List --}}
                                <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Foto</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Weight</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactionDetail as $index => $TD) 
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>
                                            @if ($TD->product->galleries)
                                            <img src="{{ Storage::url($TD->variant->photos) }}" 
                                            alt=""
                                            height="100"
                                            width="100"
                                            >
                                            @endif
                                        </td>
                                        <td>{{ $TD->product->name . " - " . $TD->variant->color }}</td>
                                        <td>{{ $TD->product->price }}</td>
                                        <td>{{ $TD->product->weight }}</td>
                                        <td>{{ $TD->quantity }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <div class="row">
                                        <div class="col-12 col-md-4">
                                            <div class="product-title">Customer Name</div>
                                                <div class="product-subtitle">{{ $transactions->user->name }}</div>
                                            </div>
                                        <div class="col-12 col-md-4">
                                            <div class="product-title">Mobile</div>
                                                <div class="product-subtitle">{{ $transactions->user->phone_number}}</div>
                                            </div>
                                        <div class="col-12 col-md-4">
                                            <div class="product-title">Date of Transaction</div>
                                                <div class="product-subtitle">{{ $transactions->created_at }}</div>
                                            </div>
                                        <div class="col-12 col-md-4">
                                            <div class="product-title">Payment Status</div>
                                                <div class="product-subtitle text-danger">{{ $transactions->transaction_status}}</div>
                                            </div>
                                        <div class="col-12 col-md-4">
                                            <div class="product-title">Shipping cost</div>
                                                <div class="product-subtitle">{{ $transactions->shipping_price }}</div>
                                            </div>
                                        <div class="col-12 col-md-4">
                                            <div class="product-title">Total Weight</div>
                                                <div class="product-subtitle">{{ $berat }}</div>
                                            </div>
                                        <div class="col-12 col-md-4">
                                            <div class="product-title">Total Amount</div>
                                                <div class="product-subtitle">Rp.{{ number_format($transactions->total_price) }}</div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <form action="{{ route('transaction.update', $transactions->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                                <div class="row">
                                    <div class="col-12 mt-4">
                                             
                                    <div class="col-12 mt-4">
                                        <h5>Shipping Infomation</h5>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Address I</div>
                                                    <div class="product-subtitle">{{ $transactions->user->address_one }}</div>
                                                </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Address II</div>
                                                    <div class="product-subtitle">{{ $transactions->user->address_two }}</div>
                                                </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Province</div>
                                                    <div class="product-subtitle">
                                                        {{ App\Models\Province::find($transactions->user->provinces_id)->province }}
                                                    </div>
                                                </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">City</div>
                                                    <div class="product-subtitle">
                                                        {{ App\Models\City::find($transactions->user->regencies_id)->city_name }}
                                                    </div>
                                                </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Postal Code</div>
                                                <div class="product-subtitle">{{ $transactions->user->zip_code }}</div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Country</div>
                                                <div class="product-subtitle">{{ $transactions->user->country }}</div>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col-12 col-md-3">
                                            <div class="product-title">Shipping status</div>
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                name="shipping_status"
                                                readonly=""
                                                v-model="shipping_status"
                                                />
                                            <!--<select name="transaction_status" class="form-control" v-model="status">
                                                <option value="PENDING" {{ $transactions->transaction_status == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                                                <option value="SHIPPING" {{ $transactions->transaction_status == 'SHIPPING' ? 'selected' : '' }}>SHIPPING</option>
                                                <option value="SUCCESS" {{ $transactions->transaction_status == 'SUCCESS' ? 'selected' : '' }}>SUCCESS</option>
                                            </select>-->
                                        </div>
                                           <!-- <template v-if="status == 'SHIPPING'">-->
                                                <div class="col-md-3">
                                                    <div class="product-title">Resi</div>
                                                    <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    name="resi"
                                                    readonly=""
                                                    v-model="resi"
                                                    />
                                                </div>
                                            <!--<div class="col-md-2">
                                                    <button 
                                                    type="submit" 
                                                    class="btn btn-success btn-block mt-4"
                                                    >Update Resi
                                                    </button>
                                                </div>
                                            </template>-->
                                        </div>
                                    </div>
                                        <div class="row mt-4">
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
            shipping_status: '{{ $transactions->transaction_status }}',
            resi: '{{ $transactions->resi }}',
          },
      });sai
    </script> 
@endpush 