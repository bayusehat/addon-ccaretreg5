<h1 class="h3 mb-2 text-gray-800">Validasi nomor dinas kantor TR5</h1>
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
        <div class="row">
            <div class="col-sm-12 col-md-12 col-xl-12">
                <a href="{{ url('val/create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Validasi Form</a>
            </div>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                    <th>No</th>
                    <th>ND INTERNET</th>
                    <th>NAMA</th>
                    <th>ALAMAT</th>
                    <th>CREATED DATE</th>
                    <th>Action</th>
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
            asynchronous: true,
            processing: true,
            destroy: true,
            ajax: {
                url: "{{ url('val/load') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'GET'
            },
            columns: [
                { name: 'id', searchable: false, orderable: true, className: 'text-center' },
                { name: 'nama'},
                { name: 'nd_internet'},
                { name: 'alamat'},
                { name: 'created'},
                { name: 'action', searchable: false, orderable: false, className: 'text-center' }
            ],
            order: [[4, 'desc']],
            iDisplayInLength: 10
        });
    }

    function deleteValidasi(id){
        $.ajax({
            url : "{{ url('val/delete') }}/"+id,
            method : 'GET',
            dataType : 'JSON',
            beforeSend:function(){
                $('body').loading()
            },
            complete:function(){
                $('body').loading('stop');
            },
            success:function(e){
                if(e.status == 200){
                    swal ( "Wohoo!" ,  "Data berhasil dihapus!" ,  "success" )
                    $('#dataTable').DataTable().ajax.reload(null, false)
                }else{
                    swal ( "Oops" ,  "Gagal menghapus data!" ,  "error" )
                }
            }
        })
    }
</script>
