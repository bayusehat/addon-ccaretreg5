<h1 class="h3 mb-2 text-gray-800">Data Transaksi</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <a href="{{ url('inv/transaksi/create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Transaksi</a>
            </div>
        </div>
        <hr>
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
                    <th>NO</th>
                    <th>NOMOR TRANSAKSI</th>
                    <th>TANGGAL TRANSAKSI</th>
                    <th>KETERANGAN</th>
                    <th>STATUS</th>
                    <th>ACTION</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
        </div>
        <!-- Modal -->
            <div class="modal fade" id="modalReceipt" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img src="" alt="" height="300px">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        {{--  <button type="button" class="btn btn-primary">Save changes</button>  --}}
                    </div>
                    </div>
                </div>
            </div>
    </div>
</div>

<script>
    $(function(){
        loadData();
        $('#cancel').hide();
        $('#update').hide();
        $('small').text('');
    });
    
    function loadData(){
        $('#dataTable').DataTable({
            asynchronous: true,
            processing: true, 
            destroy: true,
            ajax: {
                url: "{{ url('inv/transaksi/load') }}",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'GET'
            },
            columns: [
                { name: 'id', searchable: false, orderable: true, className: 'text-center' },
                { name: 'nomor' },
                { name: 'tgl' },
                { name: 'ket'},
                { name: 'status'},
                { name: 'action', searchable: false, orderable: false, className: 'text-center' }
            ],
            order: [[0, 'asc']],
            iDisplayInLength: 10 
        });
    }

    function deleteTransaksi(id){
        $.ajax({
            url : '{{ url("inv/transaksi/delete") }}/'+id,
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            success:function(res){
                if(res.status == 200){
                    $('#dataTable').DataTable().ajax.reload(null, false)
                }else{
                    alert(res.result);
                }
            }
        })
    }

    function updateStatus(id){
        $.ajax({
            url : '{{ url("inv/transaksi/update/status") }}/'+id,
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            success:function(res){
                if(res.status == 200){
                    $('#dataTable').DataTable().ajax.reload(null, false)
                }else{
                    alert(res.result);
                }
            }
        })
    }

</script>