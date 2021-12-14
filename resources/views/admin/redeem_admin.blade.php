<h1 class="h3 mb-2 text-gray-800">Redeem Point MyIndihome</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data</h6>
    </div>
    <div class="card-body">
        @if (session('witel') == 'REGIONAL 5')
        <div class="row">
            @if (request('witel'))
            <div class="col-md-12 text-right">
                <div class="form-group">
                    <label for="">ACTION</label>
                    <br>
                    <a href="{{ url('admin/redeem') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> KEMBALI</a>
                </div>
            </div>
            @else
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Witel</label>
                        <select name="witel" id="witel" class="form-control">
                            <option value="">Select Witel</option>
                            @foreach ($witel as $v)
                                <option value="{{$v->cwitel}}">{{ $v->area }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">SEARCH</label>
                        <br>
                        <button type="button" class="btn btn-success" onclick="loadData()"><i class="fa fa-search"></i> Cari</button>
                    </div>
                </div>
                <div class="col-md-6 text-right">
                    <div class="form-group">
                        <label for="">REPORT REDEEM PROGRESS</label>
                        <br>
                        <a href="{{ url('admin/redeem/report') }}" class="btn btn-info"><i class="fa fa-file"></i> Check report</a>
                    </div>
                </div>
            @endif
        </div>
        @endif
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> {{ Session::get('success')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <br>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> {{ Session::get('error')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                    <th>No</th>
                    <th>NAMA</th>
                    <th>NOMOR HP</th>
                    <th>ND</th>
                    <th>E-Mail</th>
                    <th>ALAMAT PENGIRIMAN</th>
                    <th>KODE VOUCHER</th>
                    <th>WITEL</th>
                    <th>STATUS</th>
                    <th>TYPE REDEEM</th>
                    <th>PRODUK</th>
                    <th>CREATED</th>
                    <th>ACTION</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        loadData()
    });

    function loadData(){
        var pwitel = "{{ request('witel') }}";
        console.log(pwitel);
        var witel = $("#witel").val();
        if(pwitel){
            witels = pwitel;
        }else{
            witels = witel;
        }
        var t = $('#dataTable').DataTable({
            asynchronous: true,
            processing: true, 
            destroy: true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            ajax: {
                url: "{{ url('admin/redeem/load') }}?witel="+witels,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'GET'
            },
            columns: [
                { name: 'id', searchable: false, orderable: true, className: 'text-center' },
                { name: 'nama'},
                { name: 'nomor'},
                { name: 'nd'},
                { name: 'email'},
                { name: 'alamat'},
                { name: 'kode'},
                { name: 'witel'},
                { name: 'status'},
                { name: 'jenis'},
                { name: 'produk'},
                { name: 'created',type: 'date'},
                { name: 'action', searchable: false, orderable: false, className: 'text-center' }
            ],
            order: [[11, 'desc']],
            iDisplayInLength: 10 
        });

        t.on( 'order.dt search.dt', function () {
            t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    }
</script>