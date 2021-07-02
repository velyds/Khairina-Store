@extends('layouts.admin')

@section('title')
    Dashboard Product Gallery
@endsection

@section('content')
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
        <h2 class="dashboard-title">Product Gallery</h2>
            <p class="dashboard-subtitle">
            List of Gallery
            </p>
            </div> 
        <div class="dashboard-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('productgallery.create') }}" class="btn btn-primary mb-3">
                               + Tambah Gallery Baru 
                            </a>
                            <div class="table-responsive">
                                <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Foto</th>
                                            <th>Produk</th>
                                            <th>Warna</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
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
    <script>
        var datatable = $('#crudTable').DataTable({
            processing:true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '{!! url()->current() !!}',
            },
            
            
            columns: [
                {data:'id', name:'id'},
                {data:'photos', name:'photos'},
                {data:'product.name', name:'product.name'},
                {data:'color', name:'color'},
                {data:'description', name:'description'},
                {
                    data:'action',
                    name:'action',
                    orderable: false,
                    searcable: false,
                    width:'15%'
                },
            ]
        });
    </script>
@endpush