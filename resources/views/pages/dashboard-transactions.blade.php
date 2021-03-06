@extends('layouts.dashboard')

@section('title')
Khairina Store - Transaction
@endsection

@section('content')
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">Transactions</h2>
            <p class="dashboard-subtitle">
                Big result start from the small one
            </p>
        </div>
        <div class="dashboard-content">
            <div class="row">
                <div class="col-12 mt-2">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Buy Product</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            @foreach ($buyTransactions as $transaction)
                            <a href="{{ route('dashboard-transaction-details', $transaction->id) }}" class="card card-list d-block">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <img src="{{ Storage::url($transaction->detail->first()->variant->photos ?? '') }}" class="w-75" />
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
                                            <img src="/images/dashboard-arrow.svg" alt="" />
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
</div>
</div>
@endsection