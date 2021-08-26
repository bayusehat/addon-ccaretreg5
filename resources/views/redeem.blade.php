



<!DOCTYPE html>

<html lang="en">



  <head>

    <title>Redeem Point Onsite</title>

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
        .one-line{
          display: inline;
        }
        .site-section{
          padding : none !important;
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


  {{-- <!-- 

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

  --> --}}

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
                @if(session('success'))

                    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">

                        <strong>Sukses!</strong> {{ Session::get('success')}}

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                @endif

                @if(session('error'))

                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">

                        <strong>Gagal!</strong> {{ Session::get('error')}}

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                @endif
                
                <img src="{{ asset('assets/images/redeem.png') }}" style="margin-bottom:40px;width:100%">

                <div class="row">
                  <div class="col-md-12 text-center">
                    <h3>Cara tukar point di aplikasi My Indihome</h3>
                    <img src="{{ asset('assets/images/FLOW1.png') }}" alt="" style="height: 300px">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-9 text-center">
                    <img src="{{ asset('assets/images/FLOW2.png') }}" alt="" style="height: 300px">
                  </div>
                  <div class="col-md-3 text-center">
                    <img src="{{ asset('assets/images/qr.jpg') }}" alt="" style="height: 300px">
                  </div>
                </div>
                <br>
                
                <form method="post" action="{{ url('registrasi_redeem') }}" enctype="multipart/form-data">

                @csrf

                <div class="p-3 p-lg-5 border">

                    <div class="form-group row">
                        <p class="tebal">Untuk redeem point, silakan mengisi form berikut ini:</p>

                        <div class="col-md-12">

                            <label for="nohp">Nomor Handphone yang Menerima WA / SMS <span class="text-danger">*</span></label>

                            <div class="form-inline">

                                <input type="phone" class="form-control col-md-11" id="nomor_hp" name="nomor_hp" placeholder="Nomor HP yang Menerima WA / SMS" required>

                                <button type="button" class="btn btn-primary btn-md col-md-1" onclick="getNumber()" style="color: #fff;">CARI</button>

                                @error('nomor_hp') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>

                        </div>

                    </div>

                    <div class="form-group row">

                        <div class="col-md-12">

                            <label for="nomor_inet">Nomor Internet </label>

                            <input type="text" class="form-control" name="nomor_inet" id="nomor_inet" placeholder="Nomor Internet" readonly>

                            @error('nomor_inet') <span class="text-danger">{{ $message }}</span>@enderror

                        </div>

                    </div>

                    <div class="form-group row">

                        <div class="col-md-12">

                            <label for="nama_pelanggan">Nama </label>

                            <input type="text" class="form-control" name="nama_pelanggan" id="nama_pelanggan" placeholder="Nama Pelanggan" readonly>

                            @error('nama_pelanggan') <span class="text-danger">{{ $message }}</span>@enderror

                        </div>

                    </div>

                    <div class="form-group row">

                        <div class="col-md-12">

                            <label for="alamat_pelanggan">Alamat </label>

                            <input type="text" class="form-control" name="alamat_pelanggan" id="alamat_pelanggan" placeholder="Alamat Pelanggan" readonly>

                            @error('alamat_pelanggan') <span class="text-danger">{{ $message }}</span>@enderror

                        </div>

                    </div>

                    <div class="form-group row">

                        <div class="col-md-12">

                            <label for="email_pelanggan">Email <span class="text-danger">*</span></label>

                            <input type="text" class="form-control" name="email_pelanggan" id="email_pelanggan" placeholder="Email Pelanggan">

                            @error('email_pelanggan') <span class="text-danger">{{ $message }}</span>@enderror

                        </div>

                    </div>

                    <div class="form-group row">

                        <div class="col-md-12">

                            <label for="contact_person">Nama Contact Person</label>

                            <input type="text" class="form-control" name="contact_person" id="contact_person" placeholder="Contact Person">

                            @error('contact_person') <span class="text-danger">{{ $message }}</span>@enderror

                        </div>

                    </div>

                    <div class="form-group row">

                        <div class="col-md-12">

                            <label for="alamat_pengiriman">Alamat Pengiriman <span class="text-danger">*</span></label>

                            <input type="text" class="form-control" name="alamat_pengiriman" id="alamat_pengiriman" placeholder="Alamat Pengiriman">

                            @error('alamat_pengiriman') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                    </div>

                    <div class="form-group row">

                      <div class="col-md-12">

                          <label for="pekerjaan_pelanggan">Pekerjaan <span class="text-danger">*</span></label>

                          <select name="pekerjaan_pelanggan" id="pekerjaan_pelanggan" class="form-control">
                            <option value="">-- Pilih Pekerjaan --</option>
                            @foreach ($pekerjaan as $p)
                              <option value="{{ $p->id }}">{{ $p->nama_pekerjaan }}</option>
                            @endforeach
                          </select>

                          @error('pekerjaan_pelanggan') <span class="text-danger">{{ $message }}</span>@enderror
                      </div>

                  </div>

                  <div class="form-group row">

                    <div class="col-md-12">

                        <label for="tgl_lahir_pelanggan">Tgl Lahir <span class="text-danger">*</span></label>

                        <input type="date" class="form-control" name="tgl_lahir_pelanggan" id="tgl_lahir_pelanggan" placeholder="Tanggal Lahir">

                        @error('tgl_lahir_pelanggan') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                </div>

                    {{--  <div class="form-group row">

                      <div class="col-md-12">

                          <label for="alamat_pengiriman">Bukti Redeem <span class="text-danger">*</span></label>

                          <input type="file" class="form-control" name="attachment" id="attachment" placeholder="Bukti Redeem">

                          @error('attachment') <span class="text-danger">{{ $message }}</span>@enderror
                      </div>

                  </div>  --}}

                  <div class="form-group row">

                    <div class="col-md-12">

                        <label for="kode_voucher">Kode Voucher <span class="text-danger">*</span></label>

                        <input type="text" class="form-control" name="kode_voucher" id="kode_voucher" placeholder="Masukkan kode voucher ...">

                        @error('kode_voucher') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                </div>

                    <hr>

                    
                    <div class="form-check">

                        <input type="hidden" name="cwitel" id="cwitel">
                        {{--  <input type="hidden" name="addon" id="addon">
                        <input type="hidden" name="price" id="price">  --}}

                        <p class="one-line">Untuk info lebih lanjut bisa menghubungi kami melalui WA di <a href="" id="wa" style="display: inline;padding:0">customer representative</a> kami.</p>

                        {{-- <input type="checkbox" name="disclaimer" id="disclaimer">

                        <label class="form-check-label" for="disclaimer"><a style="padding:0;text-decoration: underline;color:#0016b1" href="#" data-toggle="modal" data-target="#myModal" onclick="contentModal()">Saya menyetujui Disclaimer</a></label>

                        <br>

                        @error('disclaimer') <span class="text-danger">{{ $message }}</span>@enderror --}}

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

                  <p>*Penawaran ini hanya untuk pelanggan terbatas, pengiriman merchandise kurang lebih 1 minggu setelah submit<br>
                  <p>*Berlaku sampai dengan 30 September 2021, selama persediaan masih ada</p>

                  <div class="form-group row">

                    <div class="col-lg-12">

                      <input type="submit" class="btn btn-primary btn-lg btn-block" id="submit" name="submit" style="color: #fff;" value="SUBMIT">

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

                    url : '{{ url("getnumber_redeem") }}',

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

                            $('#alamat_pelanggan').val(res.data.alamat)

                            $('#wa').attr('href',res.data.link)

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

            var addon = $('#addon').val();

            var price = $('#price').val();

            $("#fill").text('Dengan mengakses dan/atau mengisi form pada halaman situs ini, Saya menyatakan bahwa telah menerima, membaca, memahami dan menyetujui penawaran dari Telkom Indonesia untuk berlangganan Hybrid Box (STB) Tambahan dan PLC dengan biaya tambahan sebesar Rp. 100.000 (belum termasuk ppn). Segala risiko terkait biaya tagihan di luar kesepakatan ini sepenuhnya menjadi tanggung jawab saya.');

        }

        function numberWithCommas(x) {

            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        }

    </script>

  </body>
</html>