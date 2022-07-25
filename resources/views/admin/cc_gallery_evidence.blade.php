
<h1 class="h3 mb-2 text-gray-800">Combat Churn Evidence List</h1>
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
        <h3>Evidence Kelompok {{ $kel->kelompok }}</h3>
        <hr>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xl-12">
                @foreach ($evidence as $e)
                    <a class="elem" 
                        href="{{ asset('backend/combat_churn/'.$e->attachment) }}" 
                        title="{{ $e->nd_internet .' - '. $e->nama }}" 
                        data-lcl-txt="{{ $e->nd_internet .' - '. $e->nama.' - '.$e->alamat }}" 
                        data-lcl-author="{{ $kel->kelompok }}" 
                        data-lcl-thumb="{{ asset('backend/combat_churn/'.$e->attachment) }}">
                        <img src="{{ asset('backend/combat_churn/'.$e->attachment) }}" style="width:240px;height:426px">
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="{{ asset('backend/gallery/skins/dark.css') }}">
<link rel="stylesheet" href="{{ asset('backend/gallery/skins/light.css') }}">
<link rel="stylesheet" href="{{ asset('backend/gallery/skins/minimal.css') }}">
<script src="{{ asset('backend/gallery/js/lc_lightbox.lite.js') }}"></script>
<link rel="stylesheet" href="{{ asset('backend/gallery/css/lc_lightbox.css') }}">
<script>
    $(document).ready(function(e){
        lc_lightbox('.elem', {
            wrap_class: 'lcl_fade_oc',
            gallery : true,	
            thumb_attr: 'data-lcl-thumb', 
            
            skin: 'minimal',
            radius: 0,
            padding	: 0,
            border_w: 0,
        });	
    })
</script>