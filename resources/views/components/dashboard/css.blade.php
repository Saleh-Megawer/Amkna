@section('css')
@foreach ($files as $path)
@php
$ext = strstr($path, '.css') == true ? '' : '.css';
@endphp
<link rel="stylesheet" href="{{ asset($path . $ext) }}">
@endforeach
@endsection
