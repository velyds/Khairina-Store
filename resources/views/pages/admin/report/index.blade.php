@extends('layouts.admin')

@section('title')
    Laporan Khairina Store
@endsection

@push('addon-style')
<style>
.modal{
  background-color: rgba(0, 0, 0, 0.3);
}
.modal-backdrop{
  position: relative;
}
</style>
@endpush

@section('content')
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
        <h2 class="dashboard-title">Report</h2>
            <p class="dashboard-subtitle">
            List of Report
            </p>
            </div> 
        <div class="dashboard-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                             <div class="table-responsive">
                                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama</th>
                                                <th>Jumlah Harga</th>
                                                <th>Status</th>
                                                <th>Dibuat</th>
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

    <div class="modal" tabindex="-1" role="dialog" id="pilihTanggal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Laporan</h5>
            </div>
            <div class="modal-body">
              <p>Lihat laporan berdasarkan Bulan.</p>
              <form>
                <div class="form-group">
                  <label>Dari</label>
                  <input class="form-control" type="date" id="dari-tanggal">
                </div>
                <div class="form-group">
                  <label>Sampai</label>
                  <input class="form-control" type="date" id="sampai-tanggal">
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" onclick="filter()" class="btn btn-primary">Lihat</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
          </div>
        </div>
      </div>
@endsection

@push('addon-script')
    <script>
        var datatable = $('#crudTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    text: 'Pilih bulan',
                    action: function() { $(`#pilihTanggal`).modal(`show`) }
                },
                {
                  extend: 'print',
                  text: 'Print',
                  className: 'btn btn-danger'
                },
                {
                  extend: 'excel',
                  text: 'Excel',
                  className: 'btn btn-success'
                }
            ],
            processing:true,
            serverSide: true,
            ordering: true,
            ajax: {
              url: '{!! url()->current() !!}'
            },
            columns: [
                {data:'id', name:'id'},
                {data:'user.name', name:'user.name'},
                {data:'total_price', name:'total_price'},
                {data:'transaction_status', name:'transaction_status'},
                {data:'created_at' , name:'created_at'},
            ]
        });

        async function filter() {
          let dariTanggal = new Date($('#dari-tanggal').val()).toISOString().split('T')[0];
          let sampaiTanggal = new Date($('#sampai-tanggal').val()).toISOString().split('T')[0];
          
          $("#crudTable").dataTable().fnDestroy()
          await $('#crudTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    text: 'Pilih bulan',
                    action: function() { $(`#pilihTanggal`).modal(`show`) }
                },
                {
                  extend: 'print',
                  text: 'Print',
                  className: 'btn btn-danger'
                },
                {
                  extend: 'excel',
                  text: 'Excel',
                  className: 'btn btn-success'
                }
            ],
            processing:true,
            serverSide: true,
            ordering: true,
            ajax: {
              type: "POST",
              data: {
                  _token: '{{ csrf_token() }}',
                  dari: dariTanggal,
                  ke: sampaiTanggal
              },
              url: "{{ route('filter') }}",
              error: function(bjir) {
                console.log(bjir)
              }
            },
            columns: [
                {data:'id', name:'id'},
                {data:'user.name', name:'user.name'},
                {data:'total_price', name:'total_price'},
                {data:'transaction_status', name:'transaction_status'},
                {data:'created_at' , name:'created_at'},
            ]
          });

          $(`#pilihTanggal`).modal(`hide`)
        }
    </script>
@endpush