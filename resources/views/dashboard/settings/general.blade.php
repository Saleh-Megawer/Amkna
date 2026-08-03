@extends('dashboard.layouts.master')
@section('title', 'Settings')
@section('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/pages/settings/settings.css') }}">
@endsection
@section('content')

    <x-dashboard.links-bar :links="[
        [
            'name' => 'الإعدادات العامة',
        ],
    ]" />

    <section id="settings">
        <div class="row">

            <div class="col-lg-3">
                <x-panel-with-heading title="الروابط">
                    <x-dashboard.settings.tab :tabs="$tabs" />
                </x-panel-with-heading>
            </div><!-- End Tabs -->

            <div class="col-lg-9 mb-5">
                <div class="tab-content" id="v-pills-tabContent">


                    <x-dashboard.settings.tab-content name="روابط السوشيال ميديا" tab="social">
                        <div class=" input-normal-style">
                            @foreach ($links as $key => $val)
                                <x-form-group class="dir-ltr mb-2" :properties="[
                                    'input' => [
                                        'name' => $key,
                                        'type' => 'url',
                                        'value' => getVal($row, $key),
                                        'options' => [
                                            'placeholder' => Str::headline($key) . ' Link',
                                        ],
                                    ],
                                ]" /><!-- email -->
                            @endforeach
                        </div>
                    </x-dashboard.settings.tab-content><!-- end -->

                    <x-dashboard.settings.tab-content name="معلومات الاتصال" tab="contact">

                        <div class="row">

                            <div class="col-md-6">
                                <div class=" input-normal-style">
                                    <h6 class="mb-3">البريد الإلكتروني</h6>

                                    <div id="emails-box">
                                        @foreach (explode('|', getVal($row, 'email')) as $email)
                                            @if ($loop->index == 0)
                                                <x-form-group class="dir-ltr mb-2" :properties="[
                                                    'input' => [
                                                        'name' => 'email[]',
                                                        'type' => 'email',
                                                        'value' => $email,
                                                        'options' => [
                                                            'placeholder' =>
                                                                'هذا البريد سوف يعرض في صفحات الموقع الرئيسة مثل ( اتصل بنا )',
                                                        ],
                                                    ],
                                                ]" /><!-- email -->
                                            @else
                                                <div class="parent-email">
                                                    <div class="form-row">

                                                        <div class="col-2">
                                                            <div class="btn-remove-email btn btn-soft-danger btn-block">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                                    height="18" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M4 7l16 0" />
                                                                    <path d="M10 11l0 6" />
                                                                    <path d="M14 11l0 6" />
                                                                    <path
                                                                        d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                </svg>
                                                            </div>
                                                        </div>

                                                        <div class="col-10">
                                                            <div class="form-group dir-ltr"><input type="email"
                                                                    name="email[]" value="{{ $email }}"
                                                                    data-name="email"
                                                                    data-laravel-translatable="email--lara-trans-error"
                                                                    required=""
                                                                    placeholder="هذا البريد سوف يعرض في صفحات الموقع الرئيسة مثل ( اتصل بنا )">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div><!-- end emails box -->

                                    <div class="text-left">
                                        <div id="btn-add-new-email" class="btn btn-sm btn-soft-main d-inline-block">
                                            <i class=" fa fa-plus"></i>
                                            اضافة بريد جديد
                                        </div>
                                    </div><!-- btn add new email -->

                                </div><!-- input-normal-style -->
                            </div><!-- end col -->

                            <div class="col-md-6">
                                <div class="input-normal-style">

                                    <h6 class="mb-3">رقم الهاتف ( WhatsApp )</h6>

                                    <div id="phones-box">
                                        @foreach (explode('|', getVal($row, 'phone')) as $phone)
                                            @if ($loop->index == 0)
                                                <x-form-group class="dir-ltr mb-2" :properties="[
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
                                                    <div class="form-row">
                                                        <div class="col-2">
                                                            <div class="btn-remove-phone btn btn-soft-danger btn-block">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                                    height="18" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M4 7l16 0" />
                                                                    <path d="M10 11l0 6" />
                                                                    <path d="M14 11l0 6" />
                                                                    <path
                                                                        d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="col-10">
                                                            <div class="form-group dir-ltr"><input type="number"
                                                                    name="phone[]" value="{{ $phone }}"
                                                                    data-name="phone"
                                                                    data-laravel-translatable="email--lara-trans-error"
                                                                    required="" placeholder='كود البلد يتبعه رقم الهاتف'>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    <div class=" text-left">
                                        <div id="btn-add-new-phone" class="btn btn-sm btn-soft-main d-inline-block">
                                            <i class=" fa fa-plus"></i>
                                            اضافة رقم جديد
                                        </div>
                                    </div><!-- end btn add phone -->
                                </div><!-- input-normal-style -->
                            </div><!-- end col -->



                        </div>

                    </x-dashboard.settings.tab-content><!-- end -->


                    <x-dashboard.settings.tab-content panelBody="px-0" name="الإعدادات العامة" tab="general"
                        class="fade show active">

                        <div class="px-4">
                            <div class="row">

                                <div class="col-xl-6 col-md-6">
                                    <x-form-group :properties="[
                                        'input' => [
                                            'name' => 'logo',
                                            'type' => 'file',
                                            'options' => ['accept' => 'image/*'],
                                        ],
                                        'label' => [
                                            'text' => 'الشعار',
                                        ],
                                    ]" /><!-- -->
                                </div><!-- logo -->

                                <div class="col-xl-6 col-md-6">
                                    <x-form-group :properties="[
                                        'input' => [
                                            'name' => 'footer_logo',
                                            'type' => 'file',
                                            'options' => ['accept' => 'image/*'],
                                        ],
                                        'label' => [
                                            'text' => 'شعار ال ( Footer - ذيل الصفحة )',
                                        ],
                                    ]" /><!-- -->
                                </div><!-- footer_logo -->

                            </div><!-- end row -->
                        </div>

                        <hr style="border-top: 1px dashed  rgba(128, 128, 128, .12);" class="mt-2">

                        <div class="px-4">
                            <div class="row">

                                {{-- <div class="col-xl-12">
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

                                <div class="col-md-6">
                                    <x-form-group :properties="[
                                        'textarea' => [
                                            'name' => 'website_desc',
                                            'type' => 'text',
                                            'value' => $row->website_desc,
                                            'options' => ['rows' => 3],
                                        ],
                                        'label' => [
                                            'text' => 'وصف عن المنصة',
                                        ],
                                    ]" /><!-- -->
                                </div><!-- website_desc --> --}}
{{-- 
                                <div class="col-md-6">
                                    <x-form-group :properties="[
                                        'textarea' => [
                                            'name' => 'address',
                                            'type' => 'text',
                                            'value' => $row->address,
                                            'options' => ['rows' => 3],
                                        ],
                                        'label' => [
                                            'text' => 'مقر الشركة ( العنوان )',
                                        ],
                                    ]" /><!-- -->
                                </div><!-- address --> --}}

                                <div class="col-md-12">
                                    <x-form-group class="mb-1" :properties="[
                                        'textarea' => [
                                            'name' => 'google_map_address_embed',
                                            'value' => $row->google_map_address_embed,
                                            'options' => [
                                                'rows' => '5',
                                                'placeholder' => 'قم بتضمين خريطة من جوجل لمقر الشركة',
                                                'class' => 'ltr text-left',
                                            ],
                                        ],
                                        'label' => [
                                            'text' => 'تضمين خريطة',
                                        ],
                                    ]" />
                                    <small class=" text-muted">
                                        قم بالذهاب إلي <a target="__blank" href="https://www.google.com/maps">خرائط
                                            جوجل</a>
                                        وابحث عن المكان بعد ذلك
                                        قم بمشاركة الخريطة
                                        وانسخ المحتوي بداخل قسم
                                        تضمين خريطة
                                    </small>
                                </div><!-- google_map_address_embed -->

                            </div><!-- end row -->
                        </div>

                    </x-dashboard.settings.tab-content><!-- end -->





                    {{-- <x-dashboard.settings.tab-content name="حساب الإستقبال" tab="receiving-emails">

                        <div id="receiving-emails-box">
                            @if (count($receivingEmails) != 0)
                                @foreach ($receivingEmails as $receivingEmail)
                                    @if ($loop->index == 0)
                                        <x-form-group class="dir-ltr" :properties="[
                                            'input' => [
                                                'name' => 'email[]',
                                                'type' => 'email',
                                                'value' => $receivingEmail->email,
                                                'options' => [
                                                    'placeholder' =>
                                                        'هذا الحساب سوف يستخدم لإستقبال الرسائل عبر البريد',
                                                ],
                                            ],
                                        ]" /><!-- email -->
                                    @else
                                        <div class="parent-receiving-email">
                                            <div class="row">

                                                <div class="col-2">
                                                    <div class="btn-remove-receiving-email btn btn-soft-danger btn-block"><i
                                                            class="fa fa-trash"></i></div>
                                                </div>

                                                <div class="col-10">
                                                    <div class="form-group dir-ltr"><input type="email" name="email[]"
                                                            value="{{ $receivingEmail->email }}" data-name="email"
                                                            data-laravel-translatable="email--lara-trans-error"
                                                            required=""
                                                            placeholder="هذا البريد سوف يعرض في صفحات الموقع الرئيسة مثل ( اتصل بنا )">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <x-form-group class="dir-ltr" :properties="[
                                    'input' => [
                                        'name' => 'email[]',
                                        'type' => 'email',
                                        'options' => [
                                            'placeholder' => 'هذا الحساب سوف يستخدم لإستقبال الرسائل عبر البريد',
                                        ],
                                    ],
                                ]" /><!-- email -->
                            @endif
                        </div>

                        <div class=" text-left">
                            <div id="btn-add-new-receiving-email" class="btn btn-sm btn-soft-main d-inline-block">
                                <i class=" fa fa-plus"></i>
                                اضافة بريد إستقبال جديد
                            </div>
                        </div>


                    </x-dashboard.settings.tab-content><!-- end --> --}}

                </div><!-- End Tab Content -->
            </div><!-- End Col -->

        </div><!-- End Row -->
    </section><!-- End Section -->


@endsection
<x-dashboard.js link="settings/settings.js" type="module" />
