@extends('dashboard.layouts.master')
@section('title', 'Settings')
@section('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/pages/settings/settings.css') }}">
    <style>
        .input-group-text {
            line-height: 2;
        }
    </style>
@endsection
@section('content')

    <x-dashboard.links-bar :links="[
        [
            'name' => 'إعدادات عامة',
        ],
    ]" />




    <div class="row justify-content-center">




        <div class="col-lg-3">
            <x-panel-with-heading title="الروابط">
                <x-dashboard.settings.tab :tabs="$tabs" />
            </x-panel-with-heading>
        </div><!-- End Tabs -->

        <div class="col-lg-9">
            <div class="tab-content" id="v-pills-tabContent">

                <x-dashboard.settings.tab-content name="الإعدادات العامة" class="fade show active" tab="general">
                    <div class="row">

                        <div class="col-md-6">
                            <x-form-group :properties="[
                                'input' => [
                                    'name' => 'logo',
                                    'type' => 'file',
                                    'options' => ['accept' => 'image/*'],
                                ],
                                'label' => [
                                    'text' => 'شعار الموقع',
                                ],
                            ]" /><!-- -->
                        </div><!-- logo -->

                        <div class="col-md-6">
                            <x-form-group :properties="[
                                'input' => [
                                    'name' => 'website_icon',
                                    'type' => 'file',
                                    'options' => ['accept' => 'image/*'],
                                ],
                                'label' => [
                                    'text' => 'ايقونة الموقع ' . '( 32 * 32 ) بكسل',
                                ],
                            ]" /><!-- -->
                        </div><!-- website_icon -->

                        <div class="col-md-12">
                            <x-form-group :properties="[
                                'input' => [
                                    'name' => 'website_name',
                                    'type' => 'text',
                                    'value' => $row->website_name,
                                    'options' => ['required'],
                                ],
                                'label' => [
                                    'text' => 'اسم الموقع',
                                    'options' => ['class' => 'required'],
                                ],
                            ]" /><!-- -->
                        </div><!-- website_name -->

                        <div class="col-md-12">
                            <x-form-group :properties="[
                                'textarea' => [
                                    'name' => 'website_desc',
                                    'type' => 'text',
                                    'value' => $row->website_desc,
                                    'options' => ['required', 'rows' => 8],
                                ],
                                'label' => [
                                    'text' => 'وصف عن الموقع',
                                    'options' => ['class' => 'required'],
                                ],
                            ]" /><!-- -->
                        </div><!-- website_desc -->

                    </div>
                </x-dashboard.settings.tab-content><!-- end -->

                <x-dashboard.settings.tab-content name="روابط السوشيال ميديا" tab="social">
                    @foreach ($links as $key => $val)
                        <div class=" dir-ltr input-group mb-3">
                            <div class="input-group-prepend tip" title="{{ Str::headline($key) }}">
                                <span class="input-group-text">{!! $val['icon'] !!}</span>
                            </div>
                            <input type="url" name="{{ $key }}" placeholder="" value="{{ getVal($row, $key) }}"
                                class="form-control">
                        </div>
                    @endforeach
                </x-dashboard.settings.tab-content><!-- end -->

                <x-dashboard.settings.tab-content name="معلومات الاتصال" tab="contact">
                    <div class="row">

                        <div class="col-md-6">
                            <h6 class="mb-3">البريد الإلكتروني</h6>

                            <div id="emails-box">


                                @foreach (explode('|', getVal($row, 'email')) as $email)
                                    @if ($loop->index == 0)
                                        <x-form-group class="dir-ltr" :properties="[
                                            'input' => [
                                                'name' => 'email[]',
                                                'type' => 'email',
                                                'value' => $email,
                                                // 'options' => [
                                                //     'placeholder' =>
                                                //         'هذا البريد سوف يعرض في صفحات الموقع الرئيسة مثل ( اتصل بنا )',
                                                // ],
                                            ],
                                        ]" /><!-- email -->
                                    @else
                                        <div class="parent-email">
                                            <div class="row">

                                                <div class="col-2">
                                                    <div class="btn-remove-email btn btn-soft-danger btn-block"><i
                                                            class="fa fa-trash"></i></div>
                                                </div>

                                                <div class="col-10">
                                                    <div class="form-group dir-ltr"><input type="email" name="email[]"
                                                            value="{{ $email }}" data-name="email"
                                                            data-laravel-translatable="email--lara-trans-error"
                                                            required=""
                                                            placeholder="هذا البريد سوف يعرض في صفحات الموقع الرئيسة مثل ( اتصل بنا )">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @endif
                                @endforeach


                            </div>
                            {{-- <div class=" text-left">

                                <div id="btn-add-new-email" class="btn btn-sm btn-soft-main d-inline-block">
                                    <i class=" fa fa-plus"></i>
                                    اضافة بريد جديد
                                </div>
                            </div> --}}

                        </div>


                        <div class="col-md-6">
                            <h6 class="mb-3">رقم الهاتف ( WhatsApp )</h6>

                            <div id="phones-box">
                                @foreach (explode('|', getVal($row, 'phone')) as $phone)
                                    @if ($loop->index == 0)
                                        <x-form-group class="dir-ltr" :properties="[
                                            'input' => [
                                                'name' => 'phone[]',
                                                'type' => 'number',
                                                'value' => $phone,
                                                'options' => [
                                                    'placeholder' => 'كود البلد يتبعه رقم الهاتف',
                                                ],
                                            ],
                                        ]" /><!-- phone -->
                                    @else
                                        <div class="parent-phone">
                                            <div class="row">
                                                <div class="col-2">
                                                    <div class="btn-remove-phone btn btn-soft-danger btn-block"><i
                                                            class="fa fa-trash"></i></div>
                                                </div>
                                                <div class="col-10">
                                                    <div class="form-group dir-ltr"><input type="number" name="phone[]"
                                                            value="{{ $phone }}" data-name="phone"
                                                            data-laravel-translatable="email--lara-trans-error"
                                                            required="" placeholder='كود البلد يتبعه رقم الهاتف'>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            {{-- <div class=" text-left">
                                <div id="btn-add-new-phone" class="btn btn-sm btn-soft-main d-inline-block">
                                    <i class=" fa fa-plus"></i>
                                    اضافة رقم جديد
                                </div>
                            </div> --}}

                        </div>


                    </div>
                </x-dashboard.settings.tab-content><!-- end -->

            </div>
        </div>

    </div>

@endsection
<x-dashboard.js link="settings/settings.js" type="module" />
