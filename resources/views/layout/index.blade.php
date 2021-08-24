@include('layout.head')
@include('layout.sidebar')
@if($data['content']) {{ view($data['content'], $data) }} @endif
@include('layout.foot')