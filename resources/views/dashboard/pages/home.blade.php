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
        <div class=" input-normal-style">
            <div class="row justify-content-center">

                <div class="col-md-3">
                    <x-panel-with-heading title="رفع صور جديدة">
                        <form class="form" action="{{ route('pages.home.headerSliderAttech') }}" method="POST"
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

                            <button type="submit" class="btn-block btn btn-main ">رفع</button>
                            @csrf
                        </form>
                    </x-panel-with-heading>
                </div>

                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info text-center" role="alert">
                                هذه الصور سوف تظهر في اول قسم داخل الصفحة الرئيسية
                            </div>
                            <x-panel-with-heading title="الصور الحالية">
                                <div id="headerSliderAttechExists" class="box-padding p-0 px-3 pt-3 pb-1">
                                    <ul class=" li-inside">
                                        @if ($headerSlider != null)
                                            @foreach ($headerSlider as $fileKey => $fileVal)
                                                <li>

                                                    <a href="{{ largeAsset('designs/' . $fileVal['file_name']) }}"
                                                        target="_blank">
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
                                                        action="{{ route('pages.home.headerSliderDeleteSingle') }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="slider_index"
                                                            value="{{ $fileKey }}">
                                                        <button type="submit" class="text-danger d-inline-block">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                                height="18" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M4 7l16 0" />
                                                                <path d="M10 11l0 6" />
                                                                <path d="M14 11l0 6" />
                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                            </svg>
                                                        </button>
                                                    </form>

                                                    <form class=" float-left d-inline-block"
                                                        action="{{ route('pages.home.headerSliderRankUp') }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="slider_index"
                                                            value="{{ $fileKey }}">
                                                        <input type="hidden" name="old_rank"
                                                            value="{{ $fileVal['rank'] }}">
                                                        <input type="hidden" name="id" value="{{ $fileVal['id'] }}">
                                                        <button type="submit" class="text-dark  d-inline-block">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                                height="18" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-up">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M12 5l0 14" />
                                                                <path d="M18 11l-6 -6" />
                                                                <path d="M6 11l6 -6" />
                                                            </svg>
                                                        </button>
                                                        <span class=" mx-1">-</span>
                                                    </form>

                                                    <div class="clearfix"></div>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div> <!-- box-padding -->
                            </x-panel-with-heading>
                        </div>

                        <div class="col-md-12 mb-5">
                            <x-panel-with-heading title="الوصف التعريفي علي الصور">
                                <div id="headerStoreTitleDesc" class="box-padding">
                                    <form id="form-store-title-desc"
                                        action="{{ route('pages.home.headerStoreTitleDesc') }}" method="POST"
                                        enctype="multipart/form-data">

                                        <div class="itmes">
                                            @php
                                            //    $randomNum = 
                                            @endphp
                                            @if ($headerSliderTitleDesc != null)
                                                @foreach ($headerSliderTitleDesc as $sliderTitleDesc)
                                                    <div class="row parent-slider-title-desc-row">

                                                        <div class="col-md-10 ">
                                                            <x-form-group :properties="[
                                                                'textarea' => [
                                                                    'name' => 'header_title[]',
                                                                    'type' => 'text',
                                                                    'value' => $sliderTitleDesc['title'],
                                                                    'options' => [
                                                                        'class' => 'font-16',
                                                                        'required',
                                                                        'placeholder' => 'العنوان',
                                                                        'rows' => '2',
                                                                    ],
                                                                ],
                                                            ]" /><!--  -->

                                                            <x-form-group :properties="[
                                                                'textarea' => [
                                                                    'name' => 'header_desc[]',
                                                                    'value' => $sliderTitleDesc['desc'],
                                                                    'options' => [
                                                                        'class' => 'font-16',
                                                                        // 'required',
                                                                        'rows' => 4,
                                                                        'placeholder' =>
                                                                            'الوصف كل وصف سوف يظهر مع العنوان الخاص به',
                                                                    ],
                                                                ],
                                                            ]" /><!--  -->
                                                        </div>

                                                        <div class="col-md-2">
                                                            <button type="submit"
                                                                class="btn-remove-slider-title-desc btn btn-soft-danger btn-block">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                                    height="18" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none" />
                                                                    <path d="M4 7l16 0" />
                                                                    <path d="M10 11l0 6" />
                                                                    <path d="M14 11l0 6" />
                                                                    <path
                                                                        d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                </svg>
                                                            </button>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="input-normal-style">
                                                                <div class="d-flex">

                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input"
                                                                            id="type-lang-ar-{{ $loop->index }}"
                                                                            name="lang[{{ $loop->index }}]" value="ar" required
                                                                            @checked($sliderTitleDesc['lang'] == 'ar')>
                                                                        <label class="custom-control-label cursor-pointer"
                                                                            for="type-lang-ar-{{ $loop->index }}">
                                                                            لغة عربية
                                                                        </label>
                                                                    </div>

                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input"
                                                                            id="type-lang-en-{{ $loop->index }}"
                                                                            name="lang[{{ $loop->index }}]" value="en" required
                                                                            @checked($sliderTitleDesc['lang'] == 'en')>
                                                                        <label class="custom-control-label cursor-pointer"
                                                                            for="type-lang-en-{{ $loop->index }}">
                                                                            لغة إنجليزية
                                                                        </label>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 pb-3">
                                                            <hr style="border-color:#ddd;">
                                                        </div>

                                                    </div>
                                                @endforeach
                                            @endif
                                        </div><!-- end itmes -->

                                        @csrf

                                        <button class=" btn  btn-main" type="submit">حفظ & تحديث</button>
                                        <button id="btn-add-new-slider-title-desc" class=" btn  btn-soft-main">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 5l0 14" />
                                                <path d="M5 12l14 0" />
                                            </svg>

                                            جديد</button>
                                    </form>
                                </div> <!-- box-padding -->
                            </x-panel-with-heading>
                        </div>
                    </div>
                </div>

            </div>

        </div><!-- input-normal-style -->
    </section><!-- End Section -->

@endsection
<x-dashboard.js link="settings/settings.js" type="module" />
