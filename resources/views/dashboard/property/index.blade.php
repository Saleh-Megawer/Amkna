@extends('dashboard.layouts.master')
@section('title', $linksMap['index']['title'])

@section('css')
    <style>
        .propertie-image {
            position: relative;
        }

        .availability-status-badge {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
@endsection

@section('content')


    <x-dashboard.links-bar :links="[
        [
            'name' => $linksMap['index']['title'],
        ],
    ]" :buttons="[
        [
            'name' => '<i class=\'fa fa-plus\'></i> إضافة وحدة',
            'class' => 'btn-main',
            'options' => [
                'data-toggle' => 'modal',
                'data-target' => '#model-add-property',
            ],
        ],
    ]" /><!-- links bar  -->


    <section id="properties">
        <div class="row justify-content-center">


            @can('properties_allow_search')
                <div id="search-box" class="col-lg-3">
                    <div style="top: 100px" class="sticky-top mb-4">
                        @php
                            $appendReset = null;
                            unset($filters['is_archived']);
                            if (!empty($filters)) {
                                $appendReset =
                                    '<a href=' .
                                    route('properties.index') .
                                    " class='text-danger font-13 font-weight-500 pt-1  float-left'>الغاء البحث</a><div class='clearfix'></div>";
                            }
                        @endphp

                        <x-panel-with-heading title="بحث متقدم {!! $appendReset !!}">

                            <form class=" input-normal-style label-black" action="{{ route('properties.index') }}" method="GET"
                                enctype="multipart/form-data">

                                <div class="form-group mb-3">
                                    <label for="title" class=" d-flex justify-content-between">
                                        <span>بحث بالعنوان</span>
                                        @if (request('title'))
                                            <button type="button" data-field=".input-title"
                                                class="btn-clear font-13 text-danger float-left">
                                                حذف القيمة
                                            </button>
                                        @endif
                                    </label>
                                    <input type="text" name="title" value="{{ request('title') }}"
                                        class="form-control input-title" placeholder="مثال : شقة للبيع">
                                </div><!-- title -->

                                <div id="search-fields">

                                    <div class="form-group mb-3 {{ request('neighborhood_id') == null ? 'd-none' : '' }}"
                                        data-field="neighborhood">
                                        <label for="neighborhood_id" class=" d-flex justify-content-between">
                                            <span>الحي</span>
                                            <button type="button" class="btn-close font-13 text-danger float-left"
                                                data-hide="neighborhood">
                                                <i class="fa-solid fa-xmark"></i>
                                                إلغاء
                                            </button>
                                        </label>
                                        <select name="neighborhood_id" id="neighborhood_id" class="form-control choices">
                                            <option value="">اختر الحي</option>
                                            @foreach ($neighborhoods as $neighborhood)
                                                <option value="{{ $neighborhood->id }}"
                                                    {{ request('neighborhood_id') == $neighborhood->id ? 'selected' : '' }}>
                                                    {{ $neighborhood->name }}</option>
                                            @endforeach
                                        </select>
                                    </div><!-- neighborhood -->



                                    <div class="form-group mb-3 {{ request('property_type_id') == null ? 'd-none' : '' }}"
                                        data-field="property_type">
                                        <label class="d-flex justify-content-between align-items-center">
                                            <span>نوع العقار</span>
                                            <button type="button" class="btn-close font-13 text-danger float-left"
                                                data-hide="property_type">
                                                <i class="fa-solid fa-xmark"></i>
                                                إلغاء
                                            </button>
                                        </label>
                                        <select name="property_type_id" id="property_type_id" class="form-control choices">
                                            <option value="">اختر النوع</option>
                                            @foreach ($propertyTypes as $type)
                                                <option value="{{ $type->id }}"
                                                    {{ request('property_type_id') == $type->id ? 'selected' : '' }}>
                                                    {{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div><!-- property_type -->

                                    <div class="form-group mb-3 {{ request('property_status_id') == null ? 'd-none' : '' }}"
                                        data-field="property_status">
                                        <label class="d-flex justify-content-between align-items-center">
                                            <span>حالة العقار</span>
                                            <button type="button" class="btn-close font-13 text-danger float-left"
                                                data-hide="property_status">
                                                <i class="fa-solid fa-xmark"></i>
                                                إلغاء
                                            </button>
                                        </label>
                                        <select name="property_status_id" id="property_status_id" class="form-control choices">
                                            <option value="">اختر الحالة</option>
                                            @foreach ($propertyStatuses as $status)
                                                <option value="{{ $status->id }}"
                                                    {{ request('property_status_id') == $status->id ? 'selected' : '' }}>
                                                    {{ $status->name }}</option>
                                            @endforeach
                                        </select>
                                    </div><!-- property_status -->

                                    <div class="form-group mb-3 {{ request('property_finishing_type_id') == null ? 'd-none' : '' }}"
                                        data-field="property_finishing_type_id">
                                        <label class="d-flex justify-content-between align-items-center">
                                            <span>مستوي التأسيس</span>
                                            <button type="button" class="btn-close font-13 text-danger float-left"
                                                data-hide="property_finishing_type_id">
                                                <i class="fa-solid fa-xmark"></i>
                                                إلغاء
                                            </button>
                                        </label>
                                        <select name="property_finishing_type_id" id="property_finishing_type_id"
                                            class="form-control choices">
                                            @foreach ($propertyFinishingType as $status)
                                                <option value="{{ $status->id }}"
                                                    {{ request('property_finishing_type_id') == $status->id ? 'selected' : '' }}>
                                                    {{ $status->name }}</option>
                                            @endforeach
                                        </select>
                                    </div><!-- property_finishing_type_id -->

                                    <div class="form-group {{ request('price_max') == null ? 'd-none' : '' }}"
                                        data-field="price">
                                        <label class="d-flex justify-content-between align-items-center">
                                            <span>السعر</span>
                                            <button type="button" class="btn-close font-13 text-danger float-left"
                                                data-hide="price">
                                                <i class="fa-solid fa-xmark"></i>
                                                إلغاء
                                            </button>
                                        </label>
                                        <div class="d-flex gap-2">

                                            <div class="ml-2">
                                                <x-dashboard.input-price :options="[
                                                    'name' => 'price_min',
                                                    'value' => request('price_min'),
                                                    'placeholder' => 'أقل سعر',
                                                    'icon_top' => '14px',
                                                    'required' => false,
                                                ]" />
                                            </div>

                                            <x-dashboard.input-price :options="[
                                                'name' => 'price_max',
                                                'value' => request('price_max'),
                                                'placeholder' => 'أعلى سعر',
                                                'icon_top' => '14px',
                                                'required' => false,
                                            ]" />

                                        </div>
                                    </div><!-- price -->


                                    <div class="form-group mb-3 {{ request('bathrooms') == null ? 'd-none' : '' }}"
                                        data-field="bathrooms">
                                        <label class="d-flex justify-content-between align-items-center">
                                            <span>عدد الحمامات</span>
                                            <button type="button" class="btn-close font-13 text-danger float-left"
                                                data-hide="bathrooms">
                                                <i class="fa-solid fa-xmark"></i>
                                                إلغاء
                                            </button>
                                        </label>
                                        <div class="d-flex gap-2">
                                            <input type="number" name="bathrooms" class="form-control text-center"
                                                value="{{ request('bathrooms') }}">
                                        </div>
                                    </div><!-- bathrooms -->

                                    <div class="form-group mb-3 {{ request('bedrooms') == null ? 'd-none' : '' }}"
                                        data-field="bedrooms">
                                        <label class="d-flex justify-content-between align-items-center">
                                            <span>عدد الغرف</span>
                                            <button type="button" class="btn-close font-13 text-danger float-left"
                                                data-hide="bedrooms">
                                                <i class="fa-solid fa-xmark"></i>
                                                إلغاء
                                            </button>
                                        </label>
                                        <div class="d-flex gap-2">
                                            <input type="number" name="bedrooms" class="form-control text-center"
                                                value="{{ request('bedrooms') }}">
                                        </div>
                                    </div><!-- bedrooms -->


                                </div><!-- search-fields -->



                                <div class="mb-3 icon font-weight-600 cursor-pointer" id="toggle-search-items">
                                    <span class="search-arrow-icon d-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#000000"
                                            viewBox="0 0 256 256">
                                            <path
                                                d="M168.49,199.51a12,12,0,0,1-17,17l-80-80a12,12,0,0,1,0-17l80-80a12,12,0,0,1,17,17L97,128Z">
                                            </path>
                                        </svg>
                                    </span>
                                    اختر بنود للبحث
                                </div>


                                <div id="search-items-container" class="display-none">
                                    <div class="form-row">
                                        @foreach ($search_keys as $searchKey => $searchItem)
                                            <div class="col-6 col mb-2">
                                                <button style="white-space: nowrap" type="button"
                                                    class="btn-choose-search-item btn py-2 font-weight-500 btn-sm btn-soft-third btn-block"
                                                    data-show="{{ $searchKey }}">
                                                    {{ $searchItem }}
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div><!-- search-items-container -->


                                <button type="submit" class="btn btn-third  btn-block mt-2">
                                    تطبيق البحث
                                </button>


                            </form>



                        </x-panel-with-heading>
                    </div>
                </div><!-- search -->
            @endcan


            <div class="@can('properties_allow_search'){{ 'col-lg-9 col-md-12' }} @else {{ 'col-12' }} @endcan">

                @php
                    $currentArchived = request()->get('is_archived', 0);
                @endphp

                <div class="numbers">

                    <span class="text-secondary font-weight-500 d-inline-block mb-3 font-14">
                        ( {{ $counts->active + $counts->archived }} ) كل العقارات
                    </span>

                    <span class="text-muted mx-1 font-14">|</span>

                    <a href="{{ request()->fullUrlWithQuery(['is_archived' => 0]) }}"
                        class="font-weight-500 d-inline-block mb-3 font-14 {{ $currentArchived == 0 ? 'text-primary font-weight-bold' : 'text-secondary' }}">
                        ( {{ $counts->active }} ) نشطة
                    </a>

                    <span class="text-muted mx-1 font-14">|</span>

                    <a href="{{ request()->fullUrlWithQuery(['is_archived' => 1]) }}"
                        class="font-weight-500 d-inline-block mb-3 font-14 {{ $currentArchived == 1 ? 'text-primary font-weight-bold' : 'text-secondary' }}">
                        ( {{ $counts->archived }} ) مؤرشفة
                    </a>

                </div>



                @if (count($properties) != 0)
                    <div class="row justify-content-center">
                        @foreach ($properties as $row)
                            @php
                                $propertyUrl = slugUrl('property', $row->title ?? 'p', $row->id, true);
                            @endphp
                            <div
                                class="parents @can('properties_allow_search'){{ 'col-12' }} @else {{ 'col-xl-9 col-lg-12 col-md-12' }} @endcan">
                                <div class="ca rd box p-0 mb-3">
                                    <div class="row no-gutters">

                                        <div class="col-md-4">
                                            <a href="{{ $propertyUrl }}" target="_blank">
                                                <div class="propertie-image">
                                                    <img height="260px" width="100%"
                                                        class=" radius-br radius-tr object-cover"
                                                        src="{{ propertyImage($row->main_image) }}">

                                                    <small
                                                        class="availability-status-badge font-italic badge badge-md {{ $row->availability_status->badge() }}">{{ $row->availability_status->label() }}</small>

                                                </div><!-- image -->
                                            </a>
                                        </div>

                                        <div class="col-md-8">
                                            <div class="card-body">


                                                <h5 class="card-title mt-2 fs-clamp-18-20">
                                                    @can('properties_allow_copy_link')
                                                        <a href="{{ $propertyUrl }}" class=" text-black font-weight-500"
                                                            target="_blank">
                                                            {{ $row->title }}
                                                        </a>

                                                        <button title="نسخ الرابط" data-link="{{ $propertyUrl }}"
                                                            class="tip btn-copy-link text-dark mr-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                                height="18" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-copy">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path
                                                                    d="M7 9.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667l0 -8.666" />
                                                                <path
                                                                    d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" />
                                                            </svg>
                                                        </button>
                                                    @else
                                                        {{ $row->title }}
                                                    @endcan
                                                </h5>


                                                <h6 class=" font-20 font-weight-500 icon mb-3">
                                                    <span class="d-inline-block ">
                                                        @if ($row->purpose == 'sale')
                                                            {{ number_format($row->sale_price) }}
                                                            {!! currency_icon('sm') !!}
                                                        @else
                                                            {{ number_format($row->rent_price_monthly) }}
                                                            {!! currency_icon('sm') !!}
                                                            <span class=" font-15">/ للشهر</span>
                                                        @endif
                                                    </span>
                                                </h6><!-- price -->


                                                <div class="prop d-flex flex-wrap mt-2">

                                                    @if ($row->area)
                                                        <div class="mb-2 ml-3">
                                                            <img width="16px" height="16px"
                                                                src="{{ asset('dashboard/images/icons/mtr.svg') }}"
                                                                alt="">
                                                            <span class="font-weight-500">{{ $row->area }} <small
                                                                    class="">م</small></span>
                                                        </div>
                                                    @endif <!-- area -->

                                                    @if ($row->bedrooms)
                                                        <div class="mb-2 ml-3">
                                                            <img width="16px" height="16px"
                                                                src="{{ asset('dashboard/images/icons/room.svg') }}"
                                                                alt="">
                                                            <span class="font-weight-500">{{ $row->bedrooms }}</span>
                                                        </div>
                                                    @endif <!-- bedrooms -->

                                                    @if ($row->bathrooms)
                                                        <div class="mb-2 ml-3">
                                                            <img width="16px" height="16px"
                                                                src="{{ asset('dashboard/images/icons/bathroom.svg') }}"
                                                                alt="">
                                                            <span class="font-weight-500">{{ $row->bathrooms }}</span>
                                                        </div>
                                                    @endif <!-- bathrooms -->


                                                    @if ($row?->neighborhood?->name)
                                                        <div class="mb-2 ">
                                                            <img width="16px" height="16px"
                                                                src="{{ asset('dashboard/images/icons/map-pin-simple-area.svg') }}"
                                                                alt="">
                                                            <span
                                                                class="font-weight-500">{{ $row->city?->name . ' — ' . $row->neighborhood?->name }}</span>
                                                        </div>
                                                    @endif <!-- bathrooms -->

                                                </div><!-- prop -->

                                                <p class="card-text text-secondary mb-2">
                                                    {{ Str::limit($row->description, 150) }}
                                                </p><!-- description -->

                                                <p class="card-text">

                                                    <small class="tip" title="مضيف الإعلان">
                                                        <svg width="16" height="16" fill="#4d4d4d"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                            <path
                                                                d="M406.5 399.6C387.4 352.9 341.5 320 288 320l-64 0c-53.5 0-99.4 32.9-118.5 79.6C69.9 362.2 48 311.7 48 256C48 141.1 141.1 48 256 48s208 93.1 208 208c0 55.7-21.9 106.2-57.5 143.6zm-40.1 32.7C334.4 452.4 296.6 464 256 464s-78.4-11.6-110.5-31.7c7.3-36.7 39.7-64.3 78.5-64.3l64 0c38.8 0 71.2 27.6 78.5 64.3zM256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-272a40 40 0 1 1 0-80 40 40 0 1 1 0 80zm-88-40a88 88 0 1 0 176 0 88 88 0 1 0 -176 0z" />
                                                        </svg>
                                                        {{ Str::limit($row->admin != null ? $row->admin->full_name : 'تم حذف المستخدم', 20) }}
                                                    </small>


                                                    <small title="{{ $row->created_at }}" class="tip mx-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="#4d4d4d" viewBox="0 0 256 256">
                                                            <path
                                                                d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm64-88a8,8,0,0,1-8,8H128a8,8,0,0,1-8-8V72a8,8,0,0,1,16,0v48h48A8,8,0,0,1,192,128Z">
                                                            </path>
                                                        </svg>
                                                        {{ parseTime($row->created_at) }}
                                                    </small>


                                                    <small class="tip" title="عدد المشاهدات">
                                                        <svg width="16" height="16" fill="#4d4d4d"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                            <path
                                                                d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z" />
                                                        </svg>
                                                        {{ $row->views_count }}
                                                    </small>

                                                </p><!-- date -->



                                                <div class="">
                                                    <hr>

                                                    @can('properties_allow_copy_link')
                                                        <a class="text-success"
                                                            href="https://api.whatsapp.com/send?text={{ $propertyUrl }}"
                                                            target="_blank">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                                height="18" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-brand-whatsapp">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" />
                                                                <path
                                                                    d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1" />
                                                            </svg>
                                                            مشاركة
                                                        </a>
                                                        <span class="mx-1 text-muted">|</span>
                                                    @endcan

                                                    @can('properties_edit')
                                                        @if ($row->units->count() > 0)
                                                            <a href="{{ route('properties.edit', $row->uuid) }}"
                                                                class="text-dark">
                                                                ({{ $row->units->count() }})
                                                                نموذج
                                                            </a>
                                                            <span class="mx-1 text-muted">|</span>
                                                        @endif

                                                        <a title="تعديل" href="{{ route('properties.edit', $row->uuid) }}"
                                                            class="tip text-primary">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                                height="18" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path
                                                                    d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                <path
                                                                    d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415" />
                                                                <path d="M16 5l3 3" />
                                                            </svg>
                                                        </a>
                                                        <span class="mx-1 text-muted">|</span>
                                                    @endcan


                                                    @can('properties_delete')
                                                        <form class="ajax-delete d-inline-block"
                                                            action="{{ route('properties.destroy') }}" method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                            <input type="hidden" class="id" name="id"
                                                                value="{{ $row->id }}">
                                                            <button type="submit"
                                                                data-delete="{{ 'هل انت متأكد من حذف ' . Str::limit($row->title, 50) }}"
                                                                class="text-danger">
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
                                                    @endcan

                                                    @if ($row->is_archived)
                                                        <small class=" font-italic mr-2">العقار مُؤرشف</small>
                                                    @endif



                                                    {{-- @can('properties_activate_deactivate')
                                                        <!-- زر تغيير الحالة إن وُجد -->
                                                        <form class="d-inline-block" action="{{ 1 }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="id"
                                                                value="{{ $row->id }}">
                                                            <button type="submit" class="btn btn-sm btn-soft-warning">
                                                                {{ $row->is_active ? 'إلغاء التنشيط' : 'تنشيط' }}
                                                            </button>
                                                        </form>
                                                    @endcan --}}


                                                </div>



                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    @if (!empty($filters))
                        <div class="box text-center py-5">
                            <img width="128px" src="{{ asset('dashboard/images/empty-folder.png') }}" alt="">
                            <h4 class="text-center mb-0 mt-4">لا توجد نتائج للبحث</h4>
                        </div>
                    @else
                        <div class="box text-center py-5">
                            <img width="128px" src="{{ asset('dashboard/images/empty-folder.png') }}" alt="">
                            <h4 class="text-center mb-0 mt-4">لا يوجد عقارات في النظام</h4>
                        </div>
                    @endif
                @endif

                <div class="mb-5">
                    {{-- Pagination --}}
                    <x-paginate :data="$properties" />
                </div>

            </div><!-- col-md-9 -->

        </div><!-- row -->
    </section><!-- section -->


@endsection
@section('js')
    <script>
        $(document).ready(function() {

            $('.btn-copy-link').click(function(e) {

                let link = $(this).data('link');

                // عنصر مؤقت للنسخ
                const tempInput = $('<input>');
                $('body').append(tempInput);
                tempInput.val(link).select();

                document.execCommand('copy');

                tempInput.remove();

                iziToast.info({
                    message: 'تم نسخ الرابط بنجاح',
                    timeout: 1000
                });
            });


            $('.btn-choose-search-item').click(function(e) {
                e.preventDefault();

                let btn = $(this),
                    field = btn.data('show'),
                    fieldDiv = $('[data-field="' + field + '"]');

                btn.attr('disabled', 'disabled');

                if (fieldDiv.hasClass('d-none')) {
                    fieldDiv.removeClass('d-none').hide().slideDown(150);
                }

            });

            $(".btn-close").click(function(e) {
                e.preventDefault();
                let btn = $(this);
                let $formGroup = btn.parents('.form-group');

                // إخفاء الحقل بطريقة سلسة ثم إضافة الصنف d-none
                $formGroup.slideUp(150, function() {
                    $formGroup.addClass('d-none');

                    // تفريغ القيم داخل الحقول المتنوعة
                    $formGroup.find('select').val(null).trigger(
                        'change'); // لإعادة تهيئة select2 مثلاً
                    $formGroup.find('input').val('');
                    $formGroup.find('textarea').val('');
                });

                // إعادة تفعيل زر العرض المرتبط بهذا الحقل
                $('[data-show="' + btn.data('hide') + '"]').removeAttr('disabled');
            });

            $('.btn-clear').click(function(e) {
                $($(this).data('field')).val('');
            });

            $(window).on("scroll", function() {
                let el = $(".sticky-top, .sticky-top-temp");

                if (el.length) {
                    if (el.height() > 500) {
                        el.removeClass("sticky-top").addClass("sticky-top-temp");
                    } else {
                        el.removeClass("sticky-top-temp").addClass("sticky-top");
                    }
                }
            });

            $('#toggle-search-items').on('click', function() {

                // slide toggle
                $('#search-items-container').slideToggle(200);

                // arrow rotation
                let arrow = $('.search-arrow-icon');
                let isRotated = arrow.data('rotated') === true;

                // rotate: 0 = شمال (مغلق), 90 = تحت (مفتوح)
                let rotateTo = isRotated ? 0 : -90;

                $({
                    deg: isRotated ? -90 : 0
                }).animate({
                    deg: rotateTo
                }, {
                    duration: 250,
                    step: function(now) {
                        arrow.css('transform', 'rotate(' + now + 'deg)');
                    }
                });

                arrow.data('rotated', !isRotated);
            });



        });
    </script>
@endsection
