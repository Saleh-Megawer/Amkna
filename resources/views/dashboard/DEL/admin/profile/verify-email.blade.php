@extends('dashboard.layouts.blank')

@section('content')
    <div class="container-fluid mt-5 ">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-8 col-md-9">
                <div class="box mt-5  text-center py-5 px-1">
                    <div class="icon">
                        @if ($response['status'] == 'success')
                            <i class="fa-regular fa-circle-check fa-4x text-success"></i>
                        @elseif($response['status'] == 'warning')
                            <i class="fa-solid fa-triangle-exclamation fa-4x text-warning"></i>
                        @else
                            <i class="fa-regular fa-circle-xmark fa-4x text-danger"></i>
                        @endif
                        <h4 class=" font-22 mt-3">{{ $response['message'] }}</h4>
                        <a href="{{ adminUrl('') }}">{{ dbTrans('admin.Back to home') }}</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
