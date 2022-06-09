<h1 class="h3 mb-2 text-gray-800">Mutasi Stok Item Per-Plasa</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data</h6>
    </div>
    <div class="card-body">
        {{--  <div class="row mb-3">
            <div class="col-md-3 col-sm-12 col-xl-3">
                <select name="item" id="item" class="form-control">
                    <option value="">--Pilih Item--</option>
                    @foreach ($masterItem as $it)
                        <option value="{{ $it->master }}">{{ $it->master }}</option>
                    @endforeach
                </select>
                <small class="text-danger" id="valid_item"></small>
            </div>
            <div class="col-md-3 col-sm-12 col-xl-3">
                <select name="vendor" id="vendor" class="form-control">
                    <option value="">--Pilih Vendor--</option>
                    @foreach ($masterVendor as $vd)
                        <option value="{{ $vd->master }}">{{ $vd->master }}</option>
                    @endforeach
                </select>
                <small class="text-danger" id="valid_vendor"></small>
            </div>
            <div class="col-md-3 col-sm-12 col-xl-3">
                <input type="date" class="form-control" name="tanggal_masuk" id="tanggal_masuk" placeholder="Tanggal Masuk">
                <small class="text-danger" id="valid_tanggal_masuk"></small>
            </div>
            <div class="col-md-3 col-sm-12 col-xl-3">
                <input type="text" class="form-control" name="stok" id="stok" placeholder="Stok">
                <small class="text-danger" id="valid_stok"></small>
            </div>
        </div>  --}}
        {{--  <div class="row">
            <div class="col-md-4 col-sm-12 col-xl-4">
                <button type="button" class="btn btn-success btn-block" onclick="insertItem()" id="insert"><i class="fas fa-plus"></i> Tambah</button>
                <button type="button" class="btn btn-danger btn-block" onclick="batal()" id="cancel"><i class="fas fa-times"></i> Cancel</button>
                <button type="button" class="btn btn-warning btn-block" onclick="updateItem()" id="update"><i class="fas fa-edit"></i> Update</button>
            </div>
        </div>
        <hr>  --}}
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
                    <th>ID</th>
                    <th>ITEM</th>
                    <th>TGL KIRIM</th>
                    <th>KETERANGAN</th>
                    <th>QTY OUT</th>
                    {{--  <th>STOK AKHIR</th>  --}}
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
        var ids = "{{ $plasa}}";
        loadData(ids);
    });
    
    function loadData(plasa){
        $('#dataTable').DataTable({
            asynchronous: true,
            processing: true, 
            destroy: true,
            ajax: {
                url: "{{ url('inv/report/plasa/load/detail') }}/"+plasa,
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'GET'
            },
            columns: [
                { name: 'id', searchable: false, orderable: true, className: 'text-center' },
                { name: 'item' },
                { name: 'tgl_kirim' },
                { name: 'keterangan'},
                { name: 'stok' }
            ],
            order: [[2, 'desc']],
            iDisplayInLength: 10 
        });
    }
</script>