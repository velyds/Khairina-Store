@extends('layouts.dashboard')

@section('title')
    Khairina Store - Jual Pakaian Wanita    
@endsection
@section('content')
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
        <h2 class="dashboard-title">Dashboard</h2>
            <p class="dashboard-subtitle">
            Look what you have made today!
            </p>
            </div> 
            <div class="dashboard-content">
            <div class="row mt-3">
                <div class="col-12 mt-2">
                <h5 class="mb-3">Recent Transactions</h5>
               @foreach ($transaction_data as $transaction)
                    <a 
                    href="{{ route('dashboard-transaction-details', $transaction->id) }}" 
                    class="card card-list d-block"
                    >
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-1">
                                <img 
                                    src="{{ Storage::url($transaction->detail->first()->variant->photos ?? '') }}" 
                                    class="w-75"
                                />
                            </div>
                        <div class="col-md-4">
                            {{ $transaction->detail->first()->product->name . " - " . $transaction->detail->first()->variant->color }}
                            
                            @if (count($transaction->detail) > 1)
                                <small class="ml-2">(+ {{ count($transaction->detail) - 1 }} Produk lainnya)</small>
                            @endif
                        </div>
                        <div class="col-md-3">
                             {{ $transaction->user->name }}
                        </div>
                        <div class="col-md-3">
                             {{ $transaction->created_at }}
                        </div>
                            <div class="col-md-1 d-none d-md-block">
                                <img 
                                    src="/images/dashboard-arrow.svg" 
                                    alt=""
                                />
                            </div>
                        </div>
                    </div>
                </a>
               @endforeach
            </div>
        </div>
        </div>
    </div>
    </div>
</div>
</div>
@endsection