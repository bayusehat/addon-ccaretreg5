<h1 class="h3 mb-2 text-gray-800">Combat Churn - Report Game</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data</h6>
    </div>
    <div class="card-body">
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
        {{--  <div class="row">
            <div class="col-sm-12 col-md-12 col-xl-12">
                <a href="{{ url('cc/create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Combat Churn Form</a>
            </div>  
        </div>
        <hr>  --}}
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                    <th>No</th>
                    <th>KELOMPOK</th>
                    <th>JUMLAH KUNJUNGAN</th>
                    <th>JUMLAH WINBACK</th>
                    <th>NOMINAL WINBACK</th>
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
        $('#dataTable').DataTable({
            dom: 'Bflrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns:  [ 0, 1, 2, 3 , 4],
                    }
                }
            ],
            asynchronous: true,
            processing: true, 
            destroy: true,
            ajax: {
                url: "{{ url('cc/load/game') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'GET'
            },
            columns: [
                { name: 'id', searchable: false, orderable: true, className: 'text-center' },
                { name: 'nama'},
                { name: 'nomor_hp'},
                { name: 'nd_internet'},
                { name: 'alamat'}
            ],
            order: [[4, 'desc']],
            iDisplayInLength: 10 
        });
    }
</script>