<style>
    .border-bottom{
        border: none;
        border-bottom : 1px solid grey;
        padding: 0;
    }
</style>
<h1 class="h3 mb-2 text-gray-800">Generate Kcontact</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-xl-12">
               <h2>Result Kcontact : </h2>
                <h6 id="resultkcontact"></h6>
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
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> {{ Session::get('error')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <form action="" id="formGenerate">
            @csrf
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                KCONTACT GENERATOR
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Nomor Indihome</label>
                                            <input type="text" name="nd_internet" class="form-control" placeholder="Nomor Indihome">
                                            <small class="notif text-danger" id="notif_nd_internet"></small>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Nama</label>
                                            <input type="text" name="nama" class="form-control" placeholder="Nama">
                                            <small class="notif text-danger" id="notif_nama"></small>
                                        </div>
                                        <div class="form-group">
                                            <label for="">No. HP</label>
                                            <input type="text" name="no_hp" class="form-control" placeholder="No. HP">
                                            <small class="notif text-danger" id="notif_no_hp"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">LPC</label>
                                            <input type="text" name="lpc" class="form-control" placeholder="LPC">
                                            <small class="notif text-danger" id="notif_lpc"></small>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Addon</label>
                                            <select name="addon" id="addon" class="form-control">
                                                <option value="Upgrade Speed">Upgrade Speed</option>
                                            </select>
                                            <small class="notif text-danger" id="notif_addon"></small>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Speed</label>
                                            <select name="speed" id="speed" class="form-control">
                                                <option value="20">20</option>
                                                <option value="30">30</option>
                                                <option value="40">40</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                            <small class="notif text-danger" id="notif_addon"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-success" onclick="generateK()"><i class="fas fa-refresh"></i> Generate KCONTACT</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<script>
    $(function(){
        $("resultkcontact").text('');
    });
    function generateK(){
        var formData = $('#formGenerate').serialize();
        $.ajax({
            url : '{{ url("kcontact/generate/do") }}',
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            data : formData,
            method : 'POST',
            success:function(res){
                if(res.status == 200){
                    $("#resultkcontact").text(res.result);
                }else if(res.status == 400){
                    $.each(res.errors, function (i, val) {
                        $('#notif_'+i).text(val);
                    });
                }else{
                    alert(res.result);
                } 
            }
        })
    }
</script>