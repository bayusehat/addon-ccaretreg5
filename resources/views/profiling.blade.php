



<!DOCTYPE html>

<html lang="en">



  <head>

    <title>Indihome - Profiling</title>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css?family=Rubik:400,700|Crimson+Text:400,400i" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/fonts/icomoon/style.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        .tebal{
            font-weight: 800;
        }
    </style>

    <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>

    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>

    <script src="{{ asset('assets/js/popper.min.js') }}"></script>

    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>

    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>

    <script src="{{ asset('assets/js/aos.js') }}"></script>

    <script src="j{{ asset('assets/s/main.js') }}"></script>

  </head>

  <body>

    <div class="site-wrap">

      <div class="site-navbar py-2">



        <div class="search-wrap">

          <div class="container">

            <a href="#" class="search-close js-search-close"><span class="icon-close2"></span></a>

            <form action="#" method="post">

              <input type="text" class="form-control" placeholder="Cari kata kunci dan tekan enter...">

            </form>

          </div>

        </div>

        <div class="container">

          <div class="d-flex align-items-center justify-content-between">

            <div class="logo" style="width:120px">

              <div class="site-logo">

                <a href="#" class="js-logo-clone"><img src="{{ asset('assets/images/logos.png') }}" style="width:120px"></a>

              </div>

            </div>

            <div class="main-nav d-none d-lg-block">

              {{-- <nav class="site-navigation text-right text-md-center" role="navigation">

                <ul class="site-menu js-clone-nav d-none d-lg-block">

                  <li class="has-children">

                    <a href="#">Promo</a>

                    <ul class="dropdown">

                      <li><a href="https://www.indihome.co.id/promo" target="_blank">Promo</a></li>

                      <li><a href="https://www.indihome.co.id/partnership" target="_blank">Partnership</a></li>

                    </ul>

                  </li>

                  <li class="has-children">

                    <a href="#">Paket & Add-On</a>

                    <ul class="dropdown">

                      <li><a href="https://www.indihome.co.id/paket" target="_blank">Paket</a></li>

                      <li><a href="https://www.indihome.co.id/addon" target="_blank">Add-on</a></li>

                      <li><a href="https://www.indihome.co.id/useetv" target="_blank">UseeTV</a></li>

                    </ul>

                  </li>

                  <li><a href="https://www.indihome.co.id/pusat-bantuan" target="_blank">PUSAT BANTUAN</a></li>

                  <li class="has-children">

                    <a href="#">Info Terkini</a>

                    <ul class="dropdown">

                      <li><a href="https://www.indihome.co.id/news" target="_blank">News</a></li>

                      <li><a href="https://www.indihome.co.id/events" target="_blank">Events</a></li>

                    </ul>

                  </li>

                </ul>

              </nav> --}}

            </div>

            <div class="icons">

              <a href="#" class="icons-btn d-inline-block js-search-open"><span class="icon-search" style="color: #fff;"></span></a>

              <a href="#" class="site-menu-toggle js-menu-toggle ml-3 d-inline-block d-lg-none"><span class="icon-menu"></span></a>

            </div>

            </div>

          </div>

        </div>

      </div>

  <!-- 

      <div class="bg-light py-3">

        <div class="container">

          <div class="row">

            <div class="col-md-12 mb-0">

              <a href="index.html" style="color: #e60000">Home</a> <span class="mx-2 mb-0">/</span>

              <strong class="text-black">Paket & Add-On</strong>

            </div>

          </div>

        </div>

      </div> 

  -->

      <div class="site-section" id="alertsect" name="alertsect" style="display: none;">

        <div class="container">

          <div class="row">

            <div class="col-md-12">

              <!-- <label class="alert alert-success">Selamat! Data anda telah berhasil terdaftar pada sistem kami. Agent Indihome akan menghubungi anda untuk proses lebih lanjut. Terima kasih telah berlangganan Indihome</label> -->

              <label class="alert alert-success">Selamat! Data permintaan berlangganan minipack anda telah berhasil terdaftar pada sistem kami. Agent Indihome akan menghubungi anda setelah permintaan anda selesai diproses. Terima kasih telah menggunakan Indihome</label>

            </div>

          </div>

        </div>

      </div>

      <div class="site-section" id="formsect" name="formsect">

        <div class="container">

          <div class="row">

            <div class="col-md-12">
                {{-- <img src="{{ asset('assets/images/profiling.png') }}" style="margin-bottom:40px;width:100%"> --}}
                
                <h2 class="tebal">Formulir Pembaharuan Data Pelanggan Telkom</h2>
                <p>Kami mengucapkan terima kasih dan apresiasi yang setinggi-tingginya atas kepercayaan Bapak/ Ibu yang selama ini telah setia menggunakan layanan PT Telkom Indonesia. Kami berharap kerjasama yang terjalin selama ini bersama Telkom dapat memberikan manfaat bagi Bapak / Ibu.</p>

                <p>Sebagai upaya meningkatkan kualitas pelayanan kepada pelanggan, disampaikan bahwa saat ini PT Telkom Regional V melakukan pembaharuan data pelanggan, sehingga memudahkan  pelanggan  dalam melaporkan dan penyelesaian gangguan serta mempercepat penyampaian promo/ diskon  produk-produk  TELKOM.</p>
                {{--  <img src="{{ asset('assets/images/indimovie2.jpg') }}" style="margin-bottom:10px;width:100%" >  --}}
                <p>Adapun data kontak pelanggan yang dibutuhkan adalah sebagai berikut :</p>

                <form method="post" action="{{ url('register_profiling') }}">

                @csrf

                <div class="p-3 p-lg-5 border">

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

                    <div class="form-group row">
                        {{-- <p class="tebal">Untuk berlangganan, silakan mengisi form berikut ini:</p> --}}

                        <div class="col-md-12">

                            <label for="nohp">Nomor Handphone yang Menerima WA / SMS <span class="text-danger">*</span></label>

                            <div class="form-inline">

                                <input type="phone" class="form-control col-md-11" id="nomor_hp" name="nomor_hp" placeholder="Nomor HP yang Menerima WA / SMS" required>

                                <button type="button" class="btn btn-primary btn-md col-md-1" onclick="getNumber()" style="color: #fff;">CARI DATA</button>

                                @error('nomor_hp') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>

                        </div>

                    </div>

                    <div class="form-group row">

                        <div class="col-md-12">

                            <label for="nomor_inet">Nomor Internet <span class="text-danger">*</span></label>

                            <input type="text" class="form-control" name="nomor_inet" id="nomor_inet" placeholder="Nomor Internet" readonly>

                            @error('nomor_inet') <span class="text-danger">{{ $message }}</span>@enderror

                        </div>

                    </div>

                    <div class="form-group row">

                        <div class="col-md-12">

                            <label for="nama_pelanggan">Nama <span class="text-danger">*</span></label>

                            <input type="text" class="form-control" name="nama_pelanggan" id="nama_pelanggan" placeholder="Nama Pelanggan" readonly>

                            @error('nama_pelanggan') <span class="text-danger">{{ $message }}</span>@enderror

                        </div>

                    </div>

                    <div class="form-group row">

                      <div class="col-md-12">

                          <label for="penanggung_jawab">Penanggung Jawab <span class="text-danger">*</span></label>

                          <input type="text" class="form-control" name="penanggung_jawab" id="penanggung_jawab" placeholder="Penanggung Jawab">

                          @error('penanggung_jawab') <span class="text-danger">{{ $message }}</span>@enderror

                      </div>

                  </div>
                  <div class="form-group row">

                    <div class="col-md-12">

                        <label for="hubungan">Hubungan dengan pemilik <span class="text-danger">*</span></label>

                        <select name="hubungan" id="hubungan" class="form-control">
                          <option value="">-- Pilih Hubungan --</option>
                          <option value="Pemilik">Pemilik</option>
                          <option value="Ayah">Ayah</option>
                          <option value="Ibu">Ibu</option>
                          <option value="Anak">Anak</option>
                          <option value="Kakak">Kakak</option>
                          <option value="Adik">Adik</option>
                          <option value="Pengontrak">Pengontrak</option>
                          <option value="Other">Other</option>
                        </select>

                        @error('hubungan') <span class="text-danger">{{ $message }}</span>@enderror

                    </div>

                  </div>

                    <div class="form-group row">

                        <div class="col-md-12">

                            <label for="email_pelanggan">Email</label>

                            <input type="text" class="form-control" name="email_pelanggan" id="email_pelanggan" placeholder="Email Pelanggan">

                            @error('email_pelanggan') <span class="text-danger">{{ $message }}</span>@enderror

                        </div>

                    </div>

                    <div class="form-group row">

                        <div class="col-md-12">

                            <label for="nomor_hp_alt">Nomor Handphone Alternatif (Optional)</label>

                            <input type="text" class="form-control" name="nomor_hp_alt" id="nomor_hp_alt" placeholder="Nomor Handphone Alternatif">

                        </div>

                    </div>

                    <hr>

                    
                    <div class="form-check">

                        <input type="hidden" name="cwitel" id="cwitel">
                        <input type="checkbox" name="disclaimer" id="disclaimer">
                        <label class="form-check-label" for="disclaimer"><a style="padding:0;text-decoration: underline;color:#0016b1" href="#" data-toggle="modal" data-target="#myModal" onclick="contentModal()">Saya menyetujui Disclaimer</a></label>
                        <br>
                        @error('disclaimer') <span class="text-danger">{{ $message }}</span>@enderror
                        <p>Untuk informasi lebih lanjut, helpdesk kami siap membantu Bapak / Ibu pada jam kerja. Demikian disampaikan, semoga hari-hari indah bersama Telkom dapat menjadi kenangan yang lebih berarti bagi Bapak / Ibu.</p>

                    </div>

                    <!-- Modal -->

                    <div id="myModal" class="modal fade" role="dialog">

                        <div class="modal-dialog">

                        <!-- Modal content-->

                        <div class="modal-content" style="padding:30px">

                            <div class="modal-header">

                            <h4 class="modal-title">Disclaimer</h4>

                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                            </div>

                            <div class="modal-body" style="text-align: justify;">

                            <p id="fill"></p>

                            </div>

                            <div class="modal-footer">

                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                            </div>

                        </div>

                        </div>

                    </div>

                  </br>

                  {{-- <p>*Penawaran ini hanya untuk pelanggan terbatas<br> --}}

                  <div class="form-group row">

                    <div class="col-lg-12">

                      <input type="submit" class="btn btn-primary btn-lg btn-block" id="submit" name="submit" style="color: #fff;" value="VERIFIKASI">

                    </div>

                  </div>

                </div>

              </form>

            </div>

            

          </div>

        </div>

      </div>

    </div>

    <script type="text/javascript">

        function getNumber(){

            var nomor_hp = $('#nomor_hp').val();

            if(nomor_hp != ""){

                $.ajax({

                    url : '{{ url("getnumber_profiling") }}',

                    method : 'POST',

                    headers : {

                        'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')

                    },

                    dataType : 'JSON',

                    data : {

                        'nomor_hp' : nomor_hp

                    },

                    success:function(res){

                        if(res.status == 200){

                            $('#nama_pelanggan').val(res.data.nama)

                            $('#nomor_inet').val(res.data.nd_internet)

                            $("#cwitel").val(res.data.cwitel)

                        }else{

                            alert(res.message);

                        }

                    }

                })

            }else{

                alert('Nomor Handphone tidak boleh kosong!');

                $("#nomor_hp").focus();

            }

        }



        function contentModal(){

            $("#fill").text('Disclaimer content');

        }

    </script>

  </body>
</html>