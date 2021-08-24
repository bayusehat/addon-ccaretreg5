



<!DOCTYPE html>

<html lang="en">



  <head>

    <title>Indihome</title>

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

      <div class="site-section" id="formsect" name="formsect">

        <div class="container">

          <div class="row">

            <div class="col-md-12" style="margin: 20px 0">
              <h3>Tahapan Mapping Akun MyIndihome dengan Nomor Indihome</h3>
            </div>
            <div class="col-md-12" style="margin: 20px 0">
              <h3>Panduan Menyambungkan Nomor Indihome</h3>
              <div class="row">
                @for ($i =1; $i <= 3; $i++)
                  <div class="col-md-2 col-6">
                    <img src="{{ asset('assets/images/myih/sm'.$i.'.JPG') }}" style="margin-bottom:10px;width:100%" >
                  </div>
                @endfor   
              </div>
            </div>
            <div class="col-md-12" style="margin: 20px 0">
              <h3>Panduan Verifikasi Identitas</h3>
              <div class="row">
                @for ($i =1; $i <= 6; $i++)
                  <div class="col-md-2 col-6">
                    <img src="{{ asset('assets/images/myih/vi'.$i.'.JPG') }}" style="margin-bottom:10px;width:100%" >
                  </div>
                @endfor   
              </div>
            </div>
            <div class="col-md-12" style="margin: 20px 0">
              <h3>Panduan Verifikasi Menggunakan Jaringan Wifi</h3>
              <div class="row">
                @for ($i =1; $i <= 5; $i++)
                  <div class="col-md-2 col-6">
                    <img src="{{ asset('assets/images/myih/jw'.$i.'.JPG') }}" style="margin-bottom:10px;width:100%" >
                  </div>
                @endfor   
              </div>
            </div>
            <div class="col-md-12" style="margin: 20px 0">
              <h3>Panduan Verifikasi Menggunakan Telepon Rumah</h3>
              <div class="row">
                @for ($i =1; $i <= 6; $i++)
                  <div class="col-md-2 col-6">
                    <img src="{{ asset('assets/images/myih/tr'.$i.'.JPG') }}" style="margin-bottom:10px;width:100%" >
                  </div>
                @endfor   
              </div>
            </div>
          </div>

        </div>

      </div>

    </div>
  </body>
</html>