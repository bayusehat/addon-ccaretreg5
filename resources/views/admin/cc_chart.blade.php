<h1 class="h3 mb-2 text-gray-800">Combat Churn - Chart</h1>
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
            <div class="col-md-6">
                <div id="piechart" style="width:100%"></div>
            </div>
            <div class="col-md-6">
                <div id="piechartPb" style="width:100%"></div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div id="piechartPbr" style="width:100%"></div>
            </div>
            <div class="col-md-6">
                <div id="piechartPv" style="width:100%"></div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div id="piechartKb" style="width:100%"></div>
            </div>
            <div class="col-md-6">
                <div id="piechartJp" style="width:100%"></div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div id="piechartWb" style="width:100%"></div>
            </div>
            <div class="col-md-6">
                <div id="piechartPp" style="width:100%"></div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div id="piechartPbs" style="width:100%"></div>
            </div>
            <div class="col-md-6">
                <div id="piechartPkbs" style="width:100%"></div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div id="piechartPn" style="width:100%"></div>
            </div>
            <div class="col-md-6">
                {{--  <div id="piechartPkbs" style="width:100%"></div>  --}}
            </div>
        </div>
    </div>
</div>

<script>
    google.charts.load('current', {
        callback: function () {
            alasanCabutChart();
            pengalamanBaikChart();
            pengalamanKurangBaikChart();
            providerChart();
            kebutuhanChart();
            jumlahPenggunaChart();
            winbackChart();
            paketPilihanChart();
            pengalamanBaikPsChart();
            pengalamanKurangBaikPsChart();
            posisiNteChart();
        },
        'packages':['corechart']
    });
 
        function alasanCabutChart() {
 
        var data = google.visualization.arrayToDataTable([
            ['Alasan Cabut', 'Percent'],
 
                @php
                foreach($alasan_cabut as $ac) {
                    echo "['".$ac->jawaban."', ".$ac->jml."],";
                }
                @endphp
        ]);
 
          var options = {
            title: 'Alasan Cabut Chart',
            is3D: false,
            vAxis: {
                format: 'percent',
            }
          };
 
          var chart = new google.visualization.PieChart(document.getElementById('piechart'));
 
          chart.draw(data, options);
        }

        function pengalamanBaikChart() {
 
            var data = google.visualization.arrayToDataTable([
                ['Pengalaman Baik', 'Percent'],
     
                    @php
                    foreach($pengalaman_baik_ih as $pb) {
                        echo "['".$pb->jawaban."', ".$ac->jml."],";
                    }
                    @endphp
            ]);
     
              var options = {
                title: 'Pengalaman Baik Chart',
                is3D: false,
                vAxis: {
                    format: 'percent',
                }
              };
     
              var chart = new google.visualization.PieChart(document.getElementById('piechartPb'));
     
              chart.draw(data, options);
            }
        
        function pengalamanKurangBaikChart() {
            var data = google.visualization.arrayToDataTable([
                ['Pengalaman Kurang Baik', 'Percent'],   
                    @php
                    foreach($pengalaman_kurang_baik_ih as $pkb) {
                        echo "['".$pkb->jawaban."', ".$pkb->jml."],";
                    }
                    @endphp
            ]);
            var options = {
            title: 'Pengalaman Kurang Baik Chart',
            is3D: false,
            vAxis: {
                format: 'percent',
            }
            };
            var chart = new google.visualization.PieChart(document.getElementById('piechartPbr'));
            chart.draw(data, options);
        }

        function providerChart() {
            var data = google.visualization.arrayToDataTable([
                ['Provider', 'Percent'],   
                    @php
                    foreach($provider as $pv) {
                        echo "['".$pv->jawaban."', ".$pv->jml."],";
                    }
                    @endphp
            ]);
            var options = {
            title: 'Provider Chart',
            is3D: false,
            vAxis: {
                format: 'percent',
            }
            };
            var chart = new google.visualization.PieChart(document.getElementById('piechartPv'));
            chart.draw(data, options);
        }

        function kebutuhanChart() {
            var data = google.visualization.arrayToDataTable([
                ['Kebutuhan', 'Percent'],   
                    @php
                    foreach($kebutuhan as $kb) {
                        echo "['".$kb->jawaban."', ".$kb->jml."],";
                    }
                    @endphp
            ]);
            var options = {
            title: 'Kebutuhan Chart',
            is3D: false,
            vAxis: {
                format: 'percent',
            }
            };
            var chart = new google.visualization.PieChart(document.getElementById('piechartKb'));
            chart.draw(data, options);
        }

        function jumlahPenggunaChart() {
            var data = google.visualization.arrayToDataTable([
                ['Jumlah Pengguna', 'Percent'],   
                    @php
                    foreach($jumlah_pengguna as $jp) {
                        echo "['".$jp->jawaban."', ".$jp->jml."],";
                    }
                    @endphp
            ]);
            var options = {
            title: 'Jumlah Pengguna Chart',
            is3D: false,
            vAxis: {
                format: 'percent',
            }
            };
            var chart = new google.visualization.PieChart(document.getElementById('piechartJp'));
            chart.draw(data, options);
        }

        function winbackChart() {
            var data = google.visualization.arrayToDataTable([
                ['Winback', 'Percent'],   
                    @php
                    foreach($winback as $wb) {
                        echo "['".$wb->jawaban."', ".$wb->jml."],";
                    }
                    @endphp
            ]);
            var options = {
            title: 'Winback Chart',
            is3D: false,
            vAxis: {
                format: 'percent',
            }
            };
            var chart = new google.visualization.PieChart(document.getElementById('piechartWb'));
            chart.draw(data, options);
        }

        function paketPilihanChart() {
            var data = google.visualization.arrayToDataTable([
                ['Paket Pilihan', 'Percent'],   
                    @php
                    foreach($paket_pilihan as $pp) {
                        echo "['".$pp->paket_pilihan."', ".$pp->jml."],";
                    }
                    @endphp
            ]);
            var options = {
            title: 'Paket Pilihan Chart',
            is3D: false,
            vAxis: {
                format: 'percent',
            }
            };
            var chart = new google.visualization.PieChart(document.getElementById('piechartPp'));
            chart.draw(data, options);
        }

        function pengalamanBaikPsChart() {
            var data = google.visualization.arrayToDataTable([
                ['Pengalaman Baik Provider saat ini', 'Percent'],   
                    @php
                    foreach($pengalaman_baik_ps as $pps) {
                        echo "['".$pps->jawaban."', ".$pps->jml."],";
                    }
                    @endphp
            ]);
            var options = {
            title: 'Pengalaman Baik Provider saat ini',
            is3D: false,
            vAxis: {
                format: 'percent',
            }
            };
            var chart = new google.visualization.PieChart(document.getElementById('piechartPbs'));
            chart.draw(data, options);
        }

        function pengalamanKurangBaikPsChart() {
            var data = google.visualization.arrayToDataTable([
                ['Pengalaman Kurang Baik Provider saat ini', 'Percent'],   
                    @php
                    foreach($pengalaman_kurang_baik_ps as $ppks) {
                        echo "['".$ppks->jawaban."', ".$ppks->jml."],";
                    }
                    @endphp
            ]);
            var options = {
            title: 'Pengalaman Kurang Baik Provider saat ini',
            is3D: false,
            vAxis: {
                format: 'percent',
            }
            };
            var chart = new google.visualization.PieChart(document.getElementById('piechartPkbs'));
            chart.draw(data, options);
        }

        function posisiNteChart() {
            var data = google.visualization.arrayToDataTable([
                ['Posisi NTE', 'Percent'],   
                    @php
                    foreach($posisi_nte as $pn) {
                        echo "['".$pn->jawaban."', ".$pn->jml."],";
                    }
                    @endphp
            ]);
            var options = {
            title: 'Posisi NTE Chart',
            is3D: false,
            vAxis: {
                format: 'percent',
            }
            };
            var chart = new google.visualization.PieChart(document.getElementById('piechartPn'));
            chart.draw(data, options);
        }
</script>