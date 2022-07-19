<style>
    .border-bottom{
        border: none;
        border-bottom : 1px solid grey;
        padding: 0;
    }
    .voc1_value, .voc3_value, .voc4_value, .voc5_value, .voc6_value, .voc7_value{
        display: none;
    }
    .val{
        margin-top: 10px
    }
</style>
<h1 class="h3 mb-2 text-gray-800">Combat Churn Form</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-xl-12">
                <a href="{{ url('cc') }}" class="btn btn-danger btn-sm float-right"><i class="fas fa-arrow-left"></i> Kembali ke Data Combat Churn list</a>
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
        <form action="{{ url('cc/insert') }}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                Data WO
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Warna Kelompok Anda : <span class="text-danger">*</span></label>
                                    <select name="kelompok" id="kelompok" class="form-control select2">
                                        <option value="">-- Pilih Kelompok Anda --</option>
                                        @foreach ($kelompok as $v)
                                        <option value="{{ $v->id }}" {{ old('kelompok') == $v->kelompok ? 'selected' : '' }}>{{ $v->kelompok }}</option>
                                        @endforeach
                                    </select>
                                    @error('kelompok') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-9 col-sm-9 col-xl-9">
                                            <label for="">ND Internet : <span class="text-danger">*</span></label>
                                            <input type="text" name="nd_internet" id="nd_internet" class="form-control" value="{{old('nd_internet')}}" required>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xl-3">
                                            <label for="">Cari</label>
                                            <br>
                                            <button type="button" class="btn btn-primary btn-block" id="search" onclick="searchPelanggan()"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                    @error('nd_internet') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Nama : <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" id="nama" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="">No. HP : <span class="text-danger">*</span></label>
                                    <input type="text" name="no_hp" id="no_hp" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="">Alamat : <span class="text-danger">*</span></label>
                                    <input type="text" name="alamat" id="alamat" class="form-control" readonly>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xl-6">
                                        <div class="form-group">
                                            <label for="">Nama CP : <span class="text-danger">*</span></label>
                                            <input type="text" name="cp_nama" id="cp_nama" class="form-control" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="">CP : <span class="text-danger">*</span></label>
                                            <input type="text" name="cp_num" id="cp_num" class="form-control" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Kecepatan Terakhir : <span class="text-danger">*</span></label>
                                            <input type="text" name="speed" id="speed" class="form-control" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Paket Terakhir : <span class="text-danger">*</span></label>
                                            <input type="text" name="paket" id="paket" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xl-6">
                                        <div class="form-group">
                                            <label for="">Tagihan : <span class="text-danger">*</span></label>
                                            <input type="text" name="tagihan" id="tagihan" class="form-control" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="">LoS : <span class="text-danger">*</span></label>
                                            <input type="text" name="los_cat" id="los_cat" class="form-control" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="">KContact : <span class="text-danger">*</span></label>
                                            <textarea name="kcontact" id="kcontact" cols="30" rows="10" class="form-control" readonly></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="col-sm-12 col-md-6 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            Voice of Customer
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Explore alasan pelanggan cabut IndiHome <span class="text-danger">*</span></label>
                                <p><i>Alasan cabut dapat dihubungkan dengan tagihan sebelumnya, K-Contact, perbandingan dengan kompetitor</i></p>
                                <select name="voc1[]" id="voc1" class="form-control select2-multiple" multiple="multiple">
                                    <option value="Harga Mahal" {{ old('voc1.0') == 'Harga Mahal' ? 'selected' : '' }}>Harga Mahal</option>
                                    <option value="Tagihan tidak sesuai" {{ old('voc1.1') == 'Tagihan tidak selected' ? 'checked' : '' }}>Tagihan tidak sesuai</option>
                                    <option value="Sering Gangguan" {{ old('voc1.2') == 'Sering Gangguan' ? 'selected' : '' }}>Sering Gangguan</option>
                                    <option value="Penanganan Gangguan Lambat" {{ old('voc1.3') == 'Penanganan Gangguan Lambat' ? 'selected' : '' }}>Penanganan Gangguan Lambat</option>
                                </select>
                                <input type="checkbox" name="voc1_lain" id="voc1_lain" onchange="valueChange(this,1)" value="Lain-lain"> Lain-lain
                                <div class="voc1_value val">
                                    <input type="text" class="form-control" name="voc1_value" id="voc1_value" placeholder="Jawaban Anda"> 
                                </div>
                                @error('voc1') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Apakah perangkat (seperti ONT, STB) masih ada di pelanggan? <span class="text-danger">*</span></label>
                                <select name="voc2" id="voc2" class="form-control select2">
                                   <option value="YA">YA</option>
                                   <option value="TIDAK">TIDAK</option>
                                </select>
                                @error('voc2') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Pengalaman <b>baik</b> selama menggunakan IndiHome <span class="text-danger">*</span></label>
                                <select name="voc3[]" id="voc3" class="form-control select2-multiple" multiple="multiple">
                                    <option value="Internet Stabil" {{ old('voc3.0') == 'Internet Stabil' ? 'selected' : '' }}>Internet Stabil</option>
                                    <option value="Content Menarik" {{ old('voc3.1') == 'Content Menarik' ? 'selected' : '' }}>Content Menarik</option>
                                    <option value="Penanganan Gangguan Cepat" {{ old('voc3.2') == 'Penanganan Gangguan Cepat' ? 'selected' : '' }}>Penanganan Gangguan Cepat</option>
                                    <option value="Poin Loyalty menarik" {{ old('voc3.3') == 'Poin Loyalty menarik' ? 'selected' : '' }}>Poin Loyalty menarik</option>
                                    <option value="Channel Pelayanan banyak dan mudah dijangkau" {{ old('voc3.4') == 'Channel Pelayanan banyak dan mudah dijangkau' ? 'selected' : '' }}>Channel Pelayanan banyak dan mudah dijangkau</option>
                                </select>
                                <input type="checkbox" name="voc3_lain" id="voc3_lain" onchange="valueChange(this,3)" value="Lain-lain"> Lain-lain
                                <div class="voc3_value val">
                                    <input type="text" class="form-control" name="voc3_value" id="voc3_value" placeholder="Jawaban Anda"> 
                                </div>
                                @error('voc3') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Pengalaman <b>kurang baik</b> selama menggunakan IndiHome <span class="text-danger">*</span></label>
                                <select name="voc4[]" id="voc4" class="form-control select2-multiple" multiple="multiple">
                                    <option value="Internet putus-putus" {{ old('voc4.0') == 'Internet putus-putus' ? 'selected' : '' }}>Internet putus-putus</option>
                                    <option value="Tagihan tidak sesuai" {{ old('voc4.1') == 'Tagihan tidak sesuai' ? 'selected' : '' }}>Tagihan tidak sesuai</option>
                                    <option value="Penanganan Gangguan Lama" {{ old('voc4.2') == 'Penanganan Gangguan Lama' ? 'selected' : '' }}>Penanganan Gangguan Lama</option>
                                </select>
                                <input type="checkbox" name="voc4_lain" id="voc4_lain" onchange="valueChange(this,4)" value="Lain-lain"> Lain-lain
                                <div class="voc4_value val">
                                    <input type="text" class="form-control" name="voc4_value" id="voc4_value" placeholder="Jawaban Anda"> 
                                </div>
                                @error('voc4') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Provider internet yang digunakan saat ini <span class="text-danger">*</span></label>
                                <select name="voc5[]" id="voc5" class="form-control select2-multiple" multiple="multiple">
                                    <option value="">-- Pilih Provider Anda --</option>
                                        @foreach ($provider as $ip => $p)
                                            <option value="{{ $p->id }}" {{ old('voc5'.$ip) == $p->id ? 'selected' : '' }}>{{ $p->provider }}</option>
                                        @endforeach
                                </select>
                                <input type="checkbox" name="voc5_lain" id="voc5_lain" onchange="valueChange(this,5)" value="Lain-lain"> Lain-lain
                                <div class="voc5_value val">
                                    <input type="text" class="form-control" name="voc5_value" id="voc5_value" placeholder="Jawaban Anda"> 
                                </div>
                                @error('voc5') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Kebutuhan penggunaan Internet/IndiHome <span class="text-danger">*</span></label>
                                <select name="voc6[]" id="voc6" class="form-control select2-multiple" multiple="multiple">
                                    <option value="Kebutuhan Sekolah (Mencari Tugas, Sekolah Daring)"  {{ old('voc6.0') == 'Kebutuhan Sekolah (Mencari Tugas, Sekolah Daring)' ? 'selected' : '' }}>Kebutuhan Sekolah (Mencari Tugas, Sekolah Daring)</option>
                                    <option value="Kebutuh Kerja (Bisnis, WFH, Media Creative)"  {{ old('voc6.1') == 'Kebutuh Kerja (Bisnis, WFH, Media Creative)' ? 'selected' : '' }}>Kebutuh Kerja (Bisnis, WFH, Media Creative)</option>
                                    <option value="Akses Media Hiburan (Games, Streaming, Youtube, Browsing)"  {{ old('voc6.2') == 'Akses Media Hiburan (Games, Streaming, Youtube, Browsing)' ? 'selected' : '' }}>Akses Media Hiburan (Games, Streaming, Youtube, Browsing)</option>
                                    <option value="Akses Sosial Media (Whatsapp, Twitter, IG, Facebook, TikTok)"  {{ old('voc6.3') == 'Akses Sosial Media (Whatsapp, Twitter, IG, Facebook, TikTok)' ? 'selected' : '' }}>Akses Sosial Media (Whatsapp, Twitter, IG, Facebook, TikTok)</option>
                                </select>
                                <input type="checkbox" name="voc6_lain" id="voc6_lain" onchange="valueChange(this,6)" value="Lain-lain"> Lain-lain
                                <div class="voc6_value val">
                                    <input type="text" class="form-control" name="voc6_value" id="voc6_value" placeholder="Jawaban Anda"> 
                                </div>
                                @error('voc6') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Jumlah pengguna Internet di lokasi <span class="text-danger">*</span></label>
                                <select name="voc7" id="voc7" class="form-control select2">
                                    <option value="1-3" {{ old('voc7') == '1-3' ? 'selected' : '' }}>1-3</option>
                                    <option value="3-5" {{ old('voc7') == '3-5' ? 'selected' : '' }}>3-5</option>
                                    <option value="5-7" {{ old('voc7') == '5-7' ? 'selected' : '' }}>5-7</option>
                                    <option value="7-10" {{ old('voc7') == '7-10' ? 'selected' : '' }}>7-10</option>
                                    <option value="10-12" {{ old('voc7') == '10-12' ? 'selected' : '' }}>10-12</option>
                                    <option value="12-18" {{ old('voc7') == '12-18' ? 'selected' : '' }}>12-18</option>
                                    <option value="18-25" {{ old('voc7') == '18-25' ? 'selected' : '' }}>18-25</option>
                                </select>
                                <input type="checkbox" name="voc7_lain" id="voc7_lain" onchange="valueChange(this,7)" value="Lain-lain"> Lain-lain
                                <div class="voc7_value val">
                                    <input type="text" class="form-control" name="voc7_value" id="voc7_value" placeholder="Jawaban Anda"> 
                                </div>
                                @error('voc7') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            {{--  <h2>Harapan pelanggan dalam menggunakan internet <span class="text-danger">*</span></h2>
                            <table class="table table-striped table-bordered table-condensed">
                                <tr>
                                    <th></th>
                                    <th class="text-center">Prioritas 1</th>
                                    <th class="text-center">Prioritas 2</th>
                                    <th class="text-center">Prioritas 3</th>
                                    <th class="text-center">Prioritas 4</th>
                                    <th class="text-center">Prioritas 5</th>
                                </tr>
                                
                                @foreach ($pernyataan as $p)
                                    <tr>
                                        <td>{{ $p->pernyataan }}</td>
                                        <td><input type="radio" class="form-control" name="jwb[{{$p->id}}]" value="1"></td>
                                        <td><input type="radio" class="form-control" name="jwb[{{$p->id}}]" value="2"></td>
                                        <td><input type="radio" class="form-control" name="jwb[{{$p->id}}]" value="3"></td>
                                        <td><input type="radio" class="form-control" name="jwb[{{$p->id}}]" value="4"></td>
                                        <td><input type="radio" class="form-control" name="jwb[{{$p->id}}]" value="5"></td>
                                    </tr>
                                @endforeach
                            </table>  --}}
                            <div class="form-group">
                                <label for="">Apakah ada keinginan untuk kembali menggunakan Indihome <span class="text-danger">*</span></label>
                                <select name="voc8" id="voc8" class="form-control select2" onchange="makeRules(this)">
                                    <option value="YA" {{ old('voc8') == 'YA' ? 'selected' : '' }}>YA</option>
                                    <option value="TIDAK" {{ old('voc8') == 'TIDAK' ? 'selected' : '' }}>TIDAK</option>
                                    <option value="MUNGKIN" {{ old('voc8') == 'MUNGKIN' ? 'selected' : '' }}>MUNGKIN</option>
                                </select>
                                @error('voc8') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Paket yang disetujui <span class="text-danger">*</span></label>
                                <select name="voc9" id="voc9" class="form-control select2">
                                    <option value="">-- Pilih Paket --</option>
                                    @foreach ($jenis_paket as $jp)
                                        <option value="{{ $jp->id }}" {{ old('voc9') == $jp->id ? 'selected' : '' }}>{{ $jp->nama_paket.'-'.$jp->speed.'-'.$jp->harga_paket }}</option>
                                    @endforeach
                                    
                                </select>
                                @error('voc9') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label for="">CP Pelanggan <span class="text-danger makeRule">*</span></label>
                                <input type="text" name="voc10" id="voc10" class="form-control" placeholder="Jawaban Anda">
                                @error('voc10') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Eviden Foto Bersama Pelanggan <span class="text-danger makeRule">*</span></label>
                                <input type="file" name="attachment" id="attachment" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" id="submit" class="btn btn-success btn-block">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
                    <button type="submit" class="btn btn-success float-right"><i class="fas fa-save"></i> Simpan Data</button>
                </div>
            </div> --}}
        </form>
    </div>
</div> 
<script>
    function searchPelanggan(){
        nd = $("#nd_internet").val();
        $.ajax({
            url : "{{ url('cc/search') }}?nd="+nd,
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
                    $("#nama").val(e.data[0].nama)
                    $("#alamat").val(e.data[0].alamat)
                    $("#no_hp").val(e.data[0].hp)
                    $("#cp_nama").val(e.data[0].cp_nama)
                    $("#cp_num").val(e.data[0].hp)
                    $("#tagihan").val(e.data[0].tagihan)
                    $("#speed").val(e.data[0].speed)
                    $("#paket").val(e.data[0].paket)
                    $("#los_cat").val(e.data[0].los_cat)
                    $("#kcontact").val(e.data[0].kcontact)
                }else{
                    swal ( "Oops" ,  "Data tidak ditemukan!" ,  "error" )
                }
                
            }
        })
    }

    function valueChange(e,a){
        val = $("#voc"+a).val();
        if(e.checked == true){
            $(".voc"+a+"_value").show()
        }else{
            $(".voc"+a+"_value").hide()
        }
        //if(a == 4){
        //    if(e.checked == true){
        //        $(".voc"+a+"_value").show()
        //    }else{
        //        $(".voc"+a+"_value").hide()
        //    }
        //}else{
        //    if(val == 'Lain-lain'){
        //        $(".voc"+a+"_value").show()
        //    }else{
       //         $(".voc"+a+"_value").hide()
        //    }
        //}
    }

    function makeRules(e){
        val = $(e).val();
        if(val != 'YA'){
            $("#voc9").attr('required',false);
            $("#voc10").attr('required',false);
            $(".makeRule").hide();
        }else{
            $("#voc9").attr('required',true);
            $("#voc10").attr('required',true);
            $(".makeRule").show()
        }
    }
</script>        