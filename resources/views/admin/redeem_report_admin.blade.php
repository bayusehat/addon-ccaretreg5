<style>
    #tablePlasa, #dataTable{
        display:none;
    }
</style>
<h1 class="h3 mb-2 text-gray-800">Redeem Point MyIndihome</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data</h6>
    </div>
    <div class="card-body">
        {{--  @if (session('witel') == 'REGIONAL 5')  --}}
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">JENIS REPORT</label>
                    <select name="jenis_report" id="jenis_report" class="form-control">
                        <option value="redeem">REDEEM ONSITE</option>
                        <option value="redeem-plasa">REDEEM PLASA</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">SUBMIT</label>
                    <br>
                    <button class="btn btn-success" onclick="loadData()"><i class="fas fa-refresh"></i> LOAD</button>
                </div>
            </div>
            <div class="col-md-4 text-right">
                    <div class="form-group">
                        <label for="">ACTION</label>
                        <br>
                        <a href="{{ url('admin/redeem') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> KEMBALI</a>
                    </div>
                </div>
            </div>
        {{--  @endif  --}}
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
            <table class="table table-bordered" id="tablePlasa" width="100%" cellspacing="0">
                <thead>
                  <tr>
                      <th>WITEL</th>
                      <th>POWER BANK</th>
                      <th>MOUSE</th>
                      <th>EARBUDS</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <th>TOTAL</th>
                    <th id="totPb"></th>
                    <th id="totMouse"></th>
                    <th id="totEarbuds"></th>
                </tfoot>
              </table>

            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                    <th>WITEL</th>
                    <th>JUMLAH REDEEM</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                  <th>TOTAL</th>
                  <th id="totalRep"></th>
              </tfoot>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/plug-ins/1.11.1/api/sum().js"></script>
<script>
    $(document).ready(function(){
       
    });

    function loadData(){
        var jenis = $("#jenis_report").val()
        if(jenis == 'redeem'){
            $('#dataTable').show();
            $('#tablePlasa').hide();
            $('#dataTable').DataTable({
                footerCallback: function ( row, data, start, end, display ) {
                    var api = this.api(), data;
        
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
        
                   // var jml = api
                        //.column( 1 )
                        //.data()
                        //.reduce( function (a, b) {
                            //var hsl =  intVal(a) + intVal(b);
                            //return hsl;
                        //}, 0 );
                    
                    $( api.column( 1 ).footer() ).html();
    
                },
                asynchronous: true,
                processing: true, 
                destroy: true,
                paging : false,
                ajax: {
                    url: "{{ url('admin/redeem/report/load') }}?jenis_report="+jenis,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'GET'
                },
                columns: [
                    { name: 'witel'},
                    { name: 'jumlah',className: 'jml'},
                ],
                order: [[1, 'desc']],
                iDisplayInLength: 13
            });
            total(jenis)
        }else{
            $('#dataTable').hide();
            $('#tablePlasa').show();
            $('#tablePlasa').DataTable({
                footerCallback: function ( row, data, start, end, display ) {
                    var api = this.api(), data;
        
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
        
                   // var jml = api
                        //.column( 1 )
                        //.data()
                        //.reduce( function (a, b) {
                            //var hsl =  intVal(a) + intVal(b);
                            //return hsl;
                        //}, 0 );
                    
                    $( api.column( 1 ).footer() ).html();
                    $( api.column( 2 ).footer() ).html();
                    $( api.column( 3 ).footer() ).html();
    
                },
                asynchronous: true,
                processing: true, 
                destroy: true,
                paging : false,
                ajax: {
                    url: "{{ url('admin/redeem/report/load') }}?jenis_report="+jenis,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'GET'
                },
                columns: [
                    { name: 'witel'},
                    { name: 'power_bank'},
                    { name: 'mouse'},
                    { name: 'earbuds'}
                ],
                order: [[1, 'desc']],
                iDisplayInLength: 13
            });

            total(jenis);
        }
    }

    function total(jenis){
        $.ajax({
            url: "{{ url('admin/redeem/report/total') }}?jenis_report="+jenis,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'GET',
            success:function(res){
                if(res.jenis == 'redeem'){
                    $('#totalRep').html(res.data[0].total);
                }else{
                    $('#totPb').html(res.data[0].tot_pb);
                    $('#totMouse').html(res.data[0].tot_mouse);
                    $('#totEarbuds').html(res.data[0].tot_ear);
                }
            }
        })
    }

    function numberFormat(nStr) {
        nStr += '';
        x = nStr.split(',');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
          x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
</script>