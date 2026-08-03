@extends('dashboard.layouts.master')
@section('title', 'Settings')
@section('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/pages/settings/settings.css') }}">
@endsection
@section('content')

    <x-dashboard.links-bar :links="[
        [
            'name' => 'إعدادات الصفحة الرئيسية',
        ],
    ]" />

    <section id="settings">
        <div class="row justify-content-center">

            <div class="col-md-3">
                <x-panel-with-heading title="رفع صور جديدة">
                    <form class="form" action="{{ route('headerSliderAttech') }}" method="POST"
                        enctype="multipart/form-data">

                        <x-form-group :properties="[
                            'input' => [
                                'name' => 'header_attech[]',
                                'type' => 'file',
                                'options' => [
                                    'required',
                                    'multiple',
                                    'id' => 'input-header-attech',
                                    'accept' => 'image/*',
                                ],
                            ],
                        ]" /><!-- image -->

                        <button type="submit" class="btn-block btn btn-primary ">رفع</button>
                        @csrf
                    </form>
                </x-panel-with-heading>
            </div>

            <div class="col-md-6">


                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-primary" role="alert">
                            هذه الصور سوف تظهر في اول قسم داخل الصفحة الرئيسية
                        </div>
                        <x-panel-with-heading title="الصور الحالية">
                            <div id="headerSliderAttechExists" class="box-padding p-0 px-3 pt-3 pb-1">
                                <ul class=" li-inside">

                                    @foreach ($headerSlider as $fileKey => $fileVal)
                                        <li>

                                            <a href="{{ largeAsset('designs/' . $fileVal['file_name']) }}" target="_blank">
                                                @if ($fileVal['type'] == 'video')
                                                    <b class=" text-muted">{{ 'فيديو' }}</b>
                                                @else
                                                    <b class=" text-muted">{{ 'صورة' }}</b>
                                                @endif
                                                <div dir="ltr" class=" d-inline-block">
                                                    {{ $fileVal['file_name'] }}
                                                </div>
                                            </a>


                                            <form class="float-left d-inline-block"
                                                action="{{ route('headerSliderDeleteSingle') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="slider_index" value="{{ $fileKey }}">
                                                <button type="submit" class="text-danger d-inline-block"><i
                                                        class=" fa fa-trash-alt"></i>
                                                </button>
                                            </form>

                                            <form class=" float-left d-inline-block"
                                                action="{{ route('headerSliderRankUp') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="slider_index" value="{{ $fileKey }}">
                                                <input type="hidden" name="old_rank" value="{{ $fileVal['rank'] }}">
                                                <input type="hidden" name="id" value="{{ $fileVal['id'] }}">
                                                <button type="submit" class="text-dark  d-inline-block"><i
                                                        class=" fa fa-arrow-up"></i>
                                                </button>
                                                <span class=" mx-1">-</span>
                                            </form>

                                            <div class="clearfix"></div>
                                        </li>
                                    @endforeach

                                </ul>
                            </div> <!-- box-padding -->
                        </x-panel-with-heading>
                    </div>

                    <div class="col-md-12 mb-5">
                        <x-panel-with-heading title="الوصف التعريفي علي الصور">
                            <div id="headerStoreTitleDesc" class="box-padding">
                                <form id="form-store-title-desc" action="{{ route('headerStoreTitleDesc') }}"
                                    method="POST" enctype="multipart/form-data">

                                    <div class="itmes">
                                        @foreach ($headerSliderTitleDesc as $sliderTitleDesc)
                                            <div class="row parent-slider-title-desc-row">


                                                <div class="col-md-10 ">
                                                    <x-form-group :properties="[
                                                        'input' => [
                                                            'name' => 'header_title[]',
                                                            'type' => 'text',
                                                            'value' => $sliderTitleDesc['title'],
                                                            'options' => [
                                                                'class' => 'font-16',
                                                                'required',
                                                                'placeholder' => 'العنوان',
                                                            ],
                                                        ],
                                                    ]" /><!--  -->

                                                    <x-form-group :properties="[
                                                        'textarea' => [
                                                            'name' => 'header_desc[]',
                                                            'value' => $sliderTitleDesc['desc'],
                                                            'options' => [
                                                                'class' => 'font-16',
                                                                'required',
                                                                'rows' => 4,
                                                                'placeholder' =>
                                                                    'الوصف كل وصف سوف يظهر مع العنوان الخاص به',
                                                            ],
                                                        ],
                                                    ]" /><!--  -->
                                                </div>

                                                <div class="col-md-2">
                                                    <button type="submit"
                                                        class="btn-remove-slider-title-desc btn btn-soft-danger btn-block"><i
                                                            class=" fa fa-trash-alt"></i></button>
                                                </div>

                                                <div class="col-12 pb-3">
                                                    <hr style="border-color:#ddd;">
                                                </div>

                                            </div>
                                        @endforeach

                                    </div><!-- end itmes -->

                                    @csrf

                                    <button class=" btn  btn-primary" type="submit">حفظ & تحديث</button>
                                    <button id="btn-add-new-slider-title-desc" class=" btn  btn-soft-primary"><i
                                            class=" fa fa-plus"></i> جديد</button>
                                </form>
                            </div> <!-- box-padding -->
                        </x-panel-with-heading>
                    </div>
                </div>
            </div>

        </div>




    </section><!-- End Section -->

@endsection
<x-dashboard.js link="settings/settings.js" type="module" />
