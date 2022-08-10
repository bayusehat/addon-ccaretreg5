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
            <form action="{{ url('val/insert') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" name="nd_internet" id="nd_internet" class="form-control" placeholder="Masukkan nomor internet ...">
                                    @error('nd_internet') <small class="text-danger">{{ $message }}</small>  @enderror
                                </div>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary btn-block" onclick="getData()"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama" readonly>
                            @error('nama') <small class="text-danger">{{ $message }}</small>  @enderror
                        </div>
                        <div class="form-group">
                            <label for="">ND Pots</label>
                            <input type="text" class="form-control" name="nd_pots" id="nd_pots" readonly>
                            @error('nd_pots') <small class="text-danger">{{ $message }}</small>  @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Witel</label>
                            <input type="text" name="twitel" id="twitel" class="form-control">
                            <input type="hidden" class="form-control" name="witel" id="witel" readonly>
                            @error('witel') <small class="text-danger">{{ $message }}</small>  @enderror
                        </div>
                        <div class="form-group">
                            <label for="">STO</label>
                            <input type="text" class="form-control" name="sto" id="sto" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control" readonly></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Lokasi / Unit (ex: CC TR5)</label>
                            <input type="text" name="unit" id="unit" class="form-control">
                            @error('unit') <small class="text-danger">{{ $message }}</small>  @enderror
                        </div>
                        <div class="form-group">
                            <label for="">PIC Organik / NIK Organik</label>
                            <input type="text" name="nik_pic_organik" id="nik_pic_organik" class="form-control">
                            @error('nik_pic_organik') <small class="text-danger">{{ $message }}</small>  @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Jabatan PIC</label>
                            <input type="text" name="jabatan_pic" id="jabatan_pic" class="form-control">
                            @error('jabatan_pic') <small class="text-danger">{{ $message }}</small>  @enderror
                        </div>
                        <div class="form-group">
                            <label for="">No. HP PIC</label>
                            <input type="text" name="no_hp_pic" id="no_hp_pic" class="form-control">
                            @error('no_hp_pic') <small class="text-danger">{{ $message }}</small>  @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <input type="submit" class="btn btn-success btn-block" value="Submit data Validasi">
                    </div>
                </div>
            </form>
        </div>
    </div>
<script>
    function getData(){
        nd = $("#nd_internet").val();
        $.ajax({
            url : "{{ url('val/search') }}?nd="+nd,
            method : "GET",
            dataType : "JSON",
            beforeSend:function(){
                $('body').loading()
            },
            complete:function(){
                $('body').loading('stop');
            },
            success:function(e){
                if(e.status == 200){
                    $("#nama").val(e.data.nama)
                    $("#alamat").val(e.data.alamat)
                    $("#nd_pots").val(e.data.nd_pots)
                    $("#sto").val(e.data.sto)
                    $("#witel").val(e.data.cwitel)
                    $("#twitel").val(e.data.witel)
                }else{
                    swal ( "Oops" ,  "Data tidak ditemukan!" ,  "error" )
                }

            }
        })
    }

    function deleteValidasi(id){
        $.ajax({
            url : "{{ url('val/delete/') }}/"+id,
            method : 'GET',
            dataType : "JSON",
            success:function(res){
                if(res.status == 200){
                    swal ( "Success" , res.message ,  "success" )
                    $('#dataTable').DataTable().ajax.reload(null, false)
                }else{
                    swal ( "Oops" , res.message ,  "error" )
                }
            }
        })
    }

</script>
