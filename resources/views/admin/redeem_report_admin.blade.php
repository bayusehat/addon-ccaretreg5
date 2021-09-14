<h1 class="h3 mb-2 text-gray-800">Redeem Point MyIndihome</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data</h6>
    </div>
    <div class="card-body">
        {{--  @if (session('witel') == 'REGIONAL 5')  --}}
        <div class="row">
            <div class="col-md-12 text-right">
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
        loadData()
        total();
    });

    function loadData(){
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
                url: "{{ url('admin/redeem/report/load') }}",
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
    }

    function total(){
        $.ajax({
            url: "{{ url('admin/redeem/report/total') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'GET',
            success:function(res){
                $('#totalRep').html(res[0].total);
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