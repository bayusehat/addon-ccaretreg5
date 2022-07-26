<h1 class="h3 mb-2 text-gray-800">Detail Transaksi</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">WITEL</label>
                    <select name="witel" id="witel" class="form-control">
                        @foreach ($witel as $w)
                            <option value="{{ $w->witel }}">{{ $w->witel }}</option>
                        @endforeach
                    </select>
                    <small class="text-danger" id="valid_witel"></small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">TANGGAL KIRIM</label>
                    <input type="date" class="form-control" name="tgl_kirim" id="tgl_kirim">
                </div>
                <small class="text-danger" id="valid_tgl_kirim"></small>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">KETERANGAN</label>
                    <input type="text" class="form-control" name="keterangan" id="keterangan">
                </div>
                <small class="text-danger" id="valid_keterangan"></small>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">PLASA</label>
                    <select name="plasa" id="plasa" class="form-control">
                        <option value="">-- Pilih Plasa --</option>
                        @foreach ($plasa as $p)
                            <option value="{{ $p->plasa }}">{{ $p->plasa }}</option>
                        @endforeach
                    </select>
                    <small class="text-danger" id="valid_plasa"></small>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">TIPE</label>
                    <select name="tipe" id="tipe" class="form-control">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="1">REDEEM</option>
                        <option value="2">HVC</option>
                    </select>
                    <small class="text-danger" id="valid_plasa"></small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">ITEM</label>
                    <select name="item" id="item" class="form-control">
                        @foreach ($item as $it)
                            <option value="{{ $it->id }}">{{ $it->item }}</option>
                        @endforeach
                    </select>
                    <small class="text-danger" id="valid_item"></small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">QUANTITY</label>
                    <input type="text" class="form-control" placeholder="Qty" name="quantity" id="quantity">
                </div>
                <small class="text-danger" id="valid_quantity"></small>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <br>
                    <button class="btn btn-primary btn-block" onclick="tambahDetail()"><i class="fas fa-table"></i> Tambah</button>
                </div>
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
                    <th>WITEL</th>
                    <th>PLASA</th>
                    <th>TGL KIRIM</th>
                    <th>ITEM</th>
                    <th>QUANTITY</th>
                    <th>KETERANGAN</th>
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
    });

    function loadData(){
        $('#dataTable').DataTable({
            asynchronous: true,
            processing: true,
            destroy: true,
            ajax: {
                url: "{{ url('inv/transaksi/detail/load') }}",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'GET'
            },
            columns: [
                { name: 'id', searchable: false, orderable: true, className: 'text-center' },
                { name: 'witel'},
                { name: 'plasa' },
                { name: 'tgl_kirim'},
                { name: 'item' },
                { name: 'qty' },
                { name: 'keterangan'},
                { name: 'action', searchable: false, orderable: false, className: 'text-center' }
            ],
            order: [[0, 'asc']],
            iDisplayInLength: 10
        });
    }

    function tambahDetail(){
        var plasa = $('#plasa').val();
        var item = $('#item').val();
        var qty = $('#quantity').val();
        var witel = $('#witel').val();
        var tgl_kirim = $('#tgl_kirim').val();
        var keterangan = $('#keterangan').val();
        var tipe = $("#tipe").val();

        if(qty == ''){
            alert('Quantity tidak boleh kosong!');
        }

        $.ajax({
            url : '{{ url("inv/transaksi/detail/insert") }}',
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            data : {
                'plasa' : plasa,
                'item' : item,
                'quantity': qty,
                'witel' : witel,
                'tgl_kirim' : tgl_kirim,
                'keterangan' : keterangan,
                'tipe' : tipe
            },
            method : 'POST',
            success:function(res){
                if(res.status == 200){
                    $('#quantity').val('');
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

    function deleteDetail(id){
        $.ajax({
            url : '{{ url("inv/transaksi/detail/delete") }}/'+id,
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
