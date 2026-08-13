@extends('dashboard.layouts.master')
@section('title', $linksMap['edit']['title'] . ' #' . $row->id)
<x-dashboard.css :links="[
    [
        'link' => 'properties/index.css',
    ],
    [
        'external' => 'https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css',
    ],
]" />
@section('meta')
    <meta name="property-uuid" content="{{ $row->uuid }}">
@endsection
@section('content')

    <x-dashboard.links-bar :links="[
        [
            'name' => $linksMap['index']['title'],
            'link' => $linksMap['index']['url'],
        ],
        [
            'name' => $linksMap['edit']['title'] . ' #' . $row->id,
        ],
    ]" :buttons="[
        [
            'name' => 'عرض النماذج ( ' . $row->units->count() . ' )',
            'class' => 'btn-second',
            'link' => route('properties.units.index', $row),
        ],
    ]" /><!-- links bar  -->


    <main class="mb-5">

        <x-dashboard.tabs-bar :tabs="$tabs" />

        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-12">

                <form id="update-form" class="form validate" action="{{ route('properties.update', $row->uuid) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')


                    <section id="main">
                        <div class="form-box">
                            <h5 class="mb-4 pb-2 font-weight-600">المواصفات & الخصائص</h5><!-- box-title -->
                            <div class="form-row">

                                <div class="col-lg-3 col-md-4">
                                    <x-form-group :properties="[
                                        'select' => [
                                            'name' => 'property_type_id',
                                            'list' => getPropertyTypes(),
                                            'selected' => $row->property_type_id,
                                            'options' => [
                                                'placeholder' => 'اختر نوع من القائمة',
                                                'class' => 'choices',
                                            ],
                                        ],
                                        'label' => [
                                            'text' => 'النوع العقاري',
                                            'options' => [
                                                'class' => 'required',
                                            ],
                                        ],
                                    ]" />
                                </div><!-- property_type_id -->


                                <div class="col-lg-3 col-md-4">
                                    <x-form-group :properties="[
                                        'select' => [
                                            'name' => 'purpose',
                                            'list' => collect(config('project.purpose'))
                                                ->only(['rent', 'sale'])
                                                ->map(fn ($p, $k) => [
                                                    'value' => $k,
                                                    'name' => $p['name_' . app()->getLocale()],
                                                ])
                                                ->values()
                                                ->toArray(),
                                            'value' => 'value',
                                            'text' => 'name',
                                            'selected' => $row->purpose,
                                            'options' => [
                                                'placeholder' => 'اختر الرغبة',
                                            ],
                                        ],
                                        'label' => [
                                            'text' => 'الرغبة',
                                            'options' => [
                                                'class' => 'required',
                                            ],
                                        ],
                                    ]" />
                                </div><!-- purpose -->

                                <div class="col-lg-3 col-md-4">
                                    <x-form-group :properties="[
                                        'select' => [
                                            'name' => 'facade_id',
                                            'list' => getPropertyFacade(),
                                            'options' => [
                                                'placeholder' => 'اختر واجهة',
                                                'class' => 'choices',
                                            ],
                                        ],
                                        'label' => [
                                            'text' => 'الواجهة',
                                        ],
                                    ]" />
                                </div><!-- facade_id -->

                                <div class="col-lg-3 col-md-4">
                                    <x-form-group :properties="[
                                        'select' => [
                                            'name' => 'property_finishing_type_id',
                                            'list' => $propertyFinishingType,
                                            'selected' => $row->property_finishing_type_id,
                                            'options' => [
                                                'placeholder' => 'اختر نوع',
                                                'class' => 'choices',
                                            ],
                                        ],
                                        'label' => [
                                            'text' => 'مستوي التشطيب',
                                        ],
                                    ]" />
                                </div><!-- property_finishing_type_id -->

                                <div class="col-lg-3 col-md-4">
                                    <x-form-group :properties="[
                                        'input' => [
                                            'name' => 'area',
                                            'type' => 'number',
                                            'value' => $row->area,
                                            'options' => [
                                                'required',
                                                'class' => 'ltr',
                                                'step' => 'any',
                                                'min' => 1,
                                                'max' => 25000,
                                            ],
                                        ],
                                        'label' => [
                                            'text' => 'المساحة م²',
                                            'options' => [
                                                'class' => 'required',
                                            ],
                                        ],
                                    ]" />
                                </div><!-- area -->

                                <div class="col-lg-3 col-md-4">
                                    <x-form-group :properties="[
                                        'input' => [
                                            'name' => 'bathrooms',
                                            'type' => 'number',
                                            'value' => $row->bathrooms,
                                            'options' => [
                                                'class' => 'ltr',
                                                'min' => 1,
                                                'max' => 20,
                                            ],
                                        ],
                                        'label' => [
                                            'text' => 'عدد الحمامات',
                                        ],
                                    ]" />
                                </div><!-- bathrooms -->

                                <div class="col-lg-3 col-md-4">
                                    <x-form-group :properties="[
                                        'input' => [
                                            'name' => 'bedrooms',
                                            'type' => 'number',
                                            'value' => $row->bedrooms,
                                            'options' => [
                                                'class' => 'ltr',
                                                'min' => 1,
                                                'max' => 20,
                                            ],
                                        ],
                                        'label' => [
                                            'text' => 'عدد الغرف',
                                        ],
                                    ]" />
                                </div><!-- bedrooms -->

                                <div class="col-lg-3 col-md-4">
                                    <x-form-group :properties="[
                                        'input' => [
                                            'name' => 'number_of_floors',
                                            'type' => 'number',
                                            'value' => $row->number_of_floors,
                                            'options' => [
                                                'class' => 'ltr',
                                                'min' => 0,
                                                'max' => 255,
                                            ],
                                        ],
                                        'label' => [
                                            'text' => 'عدد الادوار',
                                        ],
                                    ]" />
                                </div><!-- number_of_floors -->

                                <div class="col-lg-3 col-md-4">
                                    <x-form-group :properties="[
                                        'input' => [
                                            'name' => 'floor',
                                            'type' => 'text',
                                            'value' => $row->floor,
                                            'options' => [
                                                'class' => 'ltr',
                                                'min' => 0,
                                            ],
                                        ],
                                        'label' => [
                                            'text' => 'رقم الدور',
                                        ],
                                    ]" />
                                </div><!-- floor -->

                                <div class="col-lg-3 col-md-4">
                                    <x-form-group :properties="[
                                        'input' => [
                                            'name' => 'license_number',
                                            'type' => 'number',
                                            'value' => $row->license_number,
                                            'options' => [
                                                'class' => 'ltr',
                                            ],
                                        ],
                                        'label' => [
                                            'text' => 'رقم الترخيص',
                                        ],
                                    ]" />
                                </div><!-- license_number -->

                                <div class="col-lg-3 col-md-4">
                                    <x-form-group :properties="[
                                        'input' => [
                                            'name' => 'plan_number',
                                            'value' => $row->plan_number,
                                            'options' => [
                                                'class' => 'ltr',
                                            ],
                                        ],
                                        'label' => [
                                            'text' => 'رقم المخطط',
                                        ],
                                    ]" />
                                </div><!-- plan_number -->

                                <div class="col-lg-3 col-md-4">
                                    <x-form-group :properties="[
                                        'input' => [
                                            'name' => 'plot_number',
                                            'value' => $row->plot_number,
                                            'options' => [
                                                'class' => 'ltr',
                                            ],
                                        ],
                                        'label' => [
                                            'text' => 'رقم القطعة',
                                        ],
                                    ]" />
                                </div><!-- plot_number -->

                            </div><!--  -->
                        </div><!--  -->
                    </section>

                    <section id="price">
                        <div class="form-box">
                            <h5 class="mb-4 pb-2 font-weight-600">
                                سعر ال{{ $row->purpose_label }}
                            </h5><!-- box-title -->

                            <div class="form-row">
                                @if ($row->purpose == 'rent')
                                    <div class="col-md-3">
                                        <x-dashboard.input-price :options="[
                                            'name' => 'rent_price_monthly',
                                            'value' => $row->rent_price_monthly,
                                            'label_text' => 'شهرياً',
                                            'required' => false,
                                        ]" />
                                    </div><!--  -->

                                    <div class="col-md-3">
                                        <x-dashboard.input-price :options="[
                                            'name' => 'rent_price_quarterly',
                                            'value' => $row->rent_price_quarterly,
                                            'label_text' => 'ربع سنوي',
                                            'required' => false,
                                        ]" />
                                    </div><!--  -->

                                    <div class="col-md-3">
                                        <x-dashboard.input-price :options="[
                                            'name' => 'rent_price_semi_annually',
                                            'value' => $row->rent_price_semi_annually,
                                            'label_text' => 'نصف سنوي',
                                            'required' => false,
                                        ]" />
                                    </div><!--  -->

                                    <div class="col-md-3">
                                        <x-dashboard.input-price :options="[
                                            'name' => 'rent_price_annually',
                                            'value' => $row->rent_price_annually,
                                            'label_text' => 'سنوي',
                                            'required' => false,
                                        ]" />
                                    </div><!--  -->
                                @else
                                    <div class="col-md-12">
                                        <x-dashboard.input-price :options="[
                                            'name' => 'sale_price',
                                            'value' => $row->sale_price,
                                            'label_text' => 'سعر البيع',
                                        ]" />
                                    </div><!-- sale_price -->
                                @endif

                            </div>

                        </div><!--  -->
                    </section>

                    <section id="images">
                        <div class="form-box">
                            <h5 class="mb-4 pb-2 font-weight-600">الصور</h5><!-- box-title -->

                            <div class="form-row">

                                <div class="col-md-3 mb-4 mb-md-0">
                                    <div id="mainImageDropzone" data-url-store="{{ route('properties.upload-main-image') }}"
                                        class="dropzone dropzone-modern"></div>

                                </div>

                                <div class="col-md-9">
                                    <div id="propertyDropzone" class=" dropzone dz-clickable dropzone-modern"
                                        data-url-store="{{ route('properties.attachments.store') }}"
                                        data-url-destroy="{{ route('properties.attachments.destroy') }}"
                                        data-url-get-attachments="{{ route('properties.attachments.get') }}">
                                    </div>
                                </div>
                            </div>


                        </div><!--  -->
                    </section>

                    <section id="title-desc">
                        <div class="form-box">
                            <h5 class="mb-4 pb-2 font-weight-600">العنوان والوصف</h5><!-- box-title -->
                            <div class="form-row">

                                @foreach (languages() as $key => $val)
                                    <div class="col-12">
                                        <x-form-group :properties="[
                                            'input' => [
                                                'name' => $key . '[title]',
                                                'type' => 'text',
                                                'value' => $row->translate($key)?->title,
                                                'options' => ['required'],
                                            ],
                                            'label' => [
                                                'text' => 'عنوان الوحدة  ( ' . $val['name'] . ' )',
                                                'options' => [
                                                    'class' => 'required',
                                                ],
                                            ],
                                        ]" />
                                    </div>
                                @endforeach

                                @foreach (languages() as $key => $val)
                                    <div class="col-12">
                                        <x-form-group :properties="[
                                            'textarea' => [
                                                'name' => $key . '[description]',
                                                'type' => 'text',
                                                'value' => $row->translate($key)?->description,
                                                'options' => [
                                                    'rows' => 6,
                                                ],
                                            ],
                                            'label' => [
                                                'text' => 'الوصف والتفاصيل  ( ' . $val['name'] . ' )',
                                            ],
                                        ]" />
                                    </div>
                                @endforeach

                            </div><!--  -->
                        </div><!--  -->
                    </section>

                    <section id="features-amenities">
                        <div class="form-box">
                            <h5 class="mb-4 pb-2 font-weight-600">المميزات & المرافق</h5><!-- box-title -->
                            <div class="form-row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>المميزات</label>
                                        <select name="feature_id[]" class="form-control choices-multiple" multiple>
                                            @foreach ($features as $feature)
                                                <option value="{{ $feature->id }}"
                                                    {{ in_array($feature->id, $row->features->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                    {{ $feature->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div><!-- feature_id -->

                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label>وسائل الراحة</label>
                                        <select name="amenity_id[]" class="form-control choices-multiple" multiple>
                                            @foreach ($amenities as $amenitie)
                                                <option value="{{ $amenitie->id }}"
                                                    {{ in_array($amenitie->id, $row->amenities->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                    {{ $amenitie->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div><!-- amenity_id --> --}}

                            </div>
                        </div><!--  -->
                    </section>

                    <section id="location">
                        <div class="form-box">
                            <h5 class="mb-4 pb-2 font-weight-600">العنوان والخريطة</h5><!-- box-title -->

                            <div class="form-row">

                                <div class="col-md-6">
                                    <x-form-group :properties="[
                                        'select' => [
                                            'name' => 'city_id',
                                            'list' => $cities,
                                            'selected' => $row->city_id,
                                            'options' => [
                                                'placeholder' => 'حدد مدينة',
                                                'class' => 'choices',
                                                'data-url-get-neighborhoods' => route('neighborhoods.byCity'),
                                            ],
                                        ],
                                        'label' => [
                                            'text' => 'المدينة',
                                        ],
                                    ]" />
                                </div><!-- city_id -->

                                <div class="col-md-6">
                                    <x-form-group :properties="[
                                        'select' => [
                                            'name' => 'neighborhood_id',
                                            'list' => $neighborhoods,
                                            'selected' => $row->neighborhood_id,
                                            'options' => [
                                                'class' => 'choices',
                                            ],
                                        ],
                                        'label' => [
                                            'text' => 'المنطقة',
                                        ],
                                    ]" />
                                </div><!-- neighborhood_id -->

                            </div>

                            <div class="google_map_iframe">
                                <x-form-group class="mb-1 pt-2" :properties="[
                                    'input' => [
                                        'name' => 'google_map_iframe',
                                        'value' => $row->google_map_iframe,
                                        'options' => [
                                            'class' => 'ltr',
                                            'placeholder' => '<iframe src=\'\'></iframe>',
                                        ],
                                    ],
                                    'label' => [
                                        'text' => 'تضمين Google Maps Iframe',
                                    ],
                                ]" />
                                <small class=" text-muted">
                                    قم بالذهاب إلي <a target="__blank" href="https://www.google.com/maps">خرائط جوجل</a>
                                    وابحث عن المكان بعد ذلك
                                    قم بمشاركة الخريطة
                                    وانسخ المحتوي بداخل قسم
                                    تضمين خريطة
                                </small>
                            </div>

                        </div><!--  -->
                    </section>

                    <div class="row mb-5 ">

                        <section id="youtube-video" class="col-sm-6">
                            <div class="form-box">
                                <h5 class="mb-4 pb-2 font-weight-600">حالة الوحدة</h5><!-- box-title -->

                                <x-form-group :properties="[
                                    'select' => [
                                        'name' => 'availability_status',
                                        'list' => $availabilityStatus,
                                        'selected' => $row->availability_status->value,
                                        'options' => [
                                            'class' => '',
                                        ],
                                    ],
                                    'label' => [
                                        'text' => 'حالة الوحدة',
                                    ],
                                ]" />

                            </div><!--  -->
                        </section>

                        <section id="youtube-video" class="col-sm-6">
                            <div class="form-box">
                                <h5 class="mb-4 pb-2 font-weight-600">تضمين فيديو</h5><!-- box-title -->

                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'youtube_video_url',
                                        'type' => 'url',
                                        'value' => $row->youtube_video_url,
                                        'options' => [
                                            'class' => 'ltr',
                                            'placeholder' => 'https://www.youtube.com/watch?v=Your-Video',
                                        ],
                                    ],
                                    'label' => [
                                        'text' => 'رابط فيديو YouTube',
                                    ],
                                ]" />

                            </div><!--  -->
                        </section>

                    </div>

                    <div id="publish-buttons-bar">
                        <div class="d-flex justify-content-end align-items-center">
                            <button class="btn btn-main px-4 ml-3" type="submit">حفظ</button>

                            <div class="custom-control pl-2 custom-switch custom-switch-rtl pt-3">
                                <input type="checkbox" class="custom-control-input sr-only" id="is_archived"
                                    name="is_archived" value="1" @checked($row->is_archived)>
                                <label class="custom-control-label font-16 bg-transparent" for="is_archived">
                                    أرشفة العقار
                                </label>
                            </div>

                        </div>
                    </div><!-- Buttons -->



                </form><!-- End Form -->

            </div><!-- end col-lg-10 -->
        </div><!-- end row -->

    </main><!-- section -->


@endsection
<x-dashboard.js :links="[
    [
        'link' => 'sweetalert/sweetalert.min.js',
        'from' => 'plugins',
    ],
    [
        'external' => 'https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js',
    ],
    [
        'link' => 'properties/edit.js',
    ],
    [
        'link' => 'properties/units.js',
    ],
]" />
