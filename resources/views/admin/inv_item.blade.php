<h1 class="h3 mb-2 text-gray-800">Stok Item</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data</h6>
    </div>
    <div class="card-body">
        <div class="row mb-3">
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
        </div>
        <div class="row">
            <div class="col-md-4 col-sm-12 col-xl-4">
                <button type="button" class="btn btn-success btn-block" onclick="insertItem()" id="insert"><i class="fas fa-plus"></i> Tambah</button>
                <button type="button" class="btn btn-danger btn-block" onclick="batal()" id="cancel"><i class="fas fa-times"></i> Cancel</button>
                <button type="button" class="btn btn-warning btn-block" onclick="updateItem()" id="update"><i class="fas fa-edit"></i> Update</button>
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
                    <th>No</th>
                    <th>NAMA</th>
                    <th>VENDOR</th>
                    <th>TGL MASUK</th>
                    <th>STOK</th>
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

    function batal(){
        $('#cancel').hide();
        $('#update').hide();
        $('#item').trigger('change');
        $('#vendor').trigger('change');
        $('#tanggal_masuk').val('');
        $('#stok').val('');
        $('#insert').show();
        $('small').text('');
    }

    function btnToUpdate(){
        $('small').text('');
        $('#insert').hide();
        $('#update').show();
        $('#cancel').show();
    }
    
    function loadData(){
        $('#dataTable').DataTable({
            asynchronous: true,
            processing: true, 
            destroy: true,
            ajax: {
                url: "{{ url('inv/item/load') }}",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'GET'
            },
            columns: [
                { name: 'id', searchable: false, orderable: true, className: 'text-center' },
                { name: 'item' },
                { name: 'vendor' },
                { name: 'tgl_masuk' },
                { name: 'stok' },
                { name: 'action', searchable: false, orderable: false, className: 'text-center' }
            ],
            order: [[0, 'asc']],
            iDisplayInLength: 10 
        });
    }

    function insertItem(){
        var item = $('#item').val();
        var stok = $('#stok').val();
        var vendor = $('#vendor').val();
        var tanggal_masuk = $('#tanggal_masuk').val();
        $.ajax({
            url : '{{ url("inv/item/insert") }}',
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            data : {
                'item' : item,
                'stok' : stok,
                'vendor' : vendor,
                'tanggal_masuk' : tanggal_masuk
            },
            method : 'POST',
            success:function(res){
                if(res.status == 200){
                    $('#item').val('').trigger('change');
                    $('#vendor').val('').trigger('change');
                    $('#tanggal_masuk').val('');
                    $('#stok').val('');
                    $('#dataTable').DataTable().ajax.reload(null, false);
                }else if(res.status == 401){
                    $.each(res.errors, function (i, val) {
                        $('#valid_'+i).text(val);
                    });
                }else{
                    alert(res.result);
                } 
            }
        })
    }

    function editItem(id){
        btnToUpdate();
        $.ajax({
            url : '{{ url("inv/item/edit") }}/'+id,
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            success:function(res){
                $('#item').val(res[0].item).trigger('change')
                $('#item').val(res[0].vendor).trigger('change')
                $('#stok').val(res[0].tanggal_masuk)
                $('#stok').val(res[0].stok)
                $('#update').attr('onclick','updateItem('+res[0].id+')');
            }
        })
    }

    function updateItem(id){
        var item = $('#item').val();
        var stok = $('#stok').val();
        var vendor = $('#vendor').val();
        var tanggal_masuk = $('#tanggal_masuk').val();
        $.ajax({
            url : '{{ url("inv/item/update") }}/'+id,
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            data : {
                'item' : item,
                'stok' : stok,
                'vendor' : vendor,
                'tanggal_masuk' : tanggal_masuk
            },
            method : 'POST',
            success:function(res){
                if(res.status == 200){
                    $('#dataTable').DataTable().ajax.reload(null, false);
                    $('#insert').show();
                    $('#cancel').hide();
                    $('#update').hide();
                    $('small').text('');
                    $('#item').val('').trigger('change');
                    $('#vendor').val('').trigger('change');
                    $('#tanggal_masuk').val('');
                    $('#stok').val('');
                }else if(res.status == 401){
                    $.each(res.errors, function (i, val) {
                        $('#valid_'+i).text(val);
                    });
                }else{
                    alert(res.result);
                } 
            }
        })
    }

    function deleteItem(id){
        $.ajax({
            url : '{{ url("inv/item/delete") }}/'+id,
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