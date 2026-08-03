@extends('dashboard.layouts.master')
@section('title', $linksMap['edit']['title'] . ' #' . $row->id)
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
            'link' => route('properties.edit', $row),
        ],
        [
            'name' => 'النماذج',
        ],
    ]" :buttons="[
        [
            'name' => 'الرجوع للوحدة',
            'class' => 'btn-second',
            'link' => route('properties.edit', $row),
        ],
    ]" /><!-- links bar  -->


    <div class="row mb-5">

        <div class="col-xl-4 col-lg-6 col-md-4">
            <x-panel-with-heading title="اضافة نموذج جديد">
                <form id="update-form" class="form validate" action="{{ route('properties.units.store', $row) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="item_id" value="">

                    <div class="item-image-input">

                        <div class="image-container text-center border display-none mb-3 p-2 radius">
                            <img style="height: 200px;" class="item-edit-image w-100 object-content img" src=""
                                alt="">
                        </div>

                        <x-form-group class="mt-0" :properties="[
                            'input' => [
                                'name' => 'image',
                                'type' => 'file',
                                'options' => [
                                    'class' => 'input-img',
                                    'accept' => 'image/*',
                                ],
                            ],
                            'label' => [
                                'text' => 'صورة للنموذج',
                            ],
                        ]" /><!-- image -->

                    </div>

                    <x-form-group :properties="[
                        'input' => [
                            'name' => 'unit_number',
                            'type' => 'text',
                            'options' => ['required', 'placeholder' => 'مثال : A, B, C, D, E, F,...'],
                        ],
                        'label' => [
                            'text' => 'اسم النموذج',
                            'options' => [
                                'class' => 'required',
                            ],
                        ],
                    ]" /> <!-- unit_number -->

                    <div class="form-row">

                        <div class="col-6">
                            <x-form-group :properties="[
                                'input' => [
                                    'name' => 'bedrooms',
                                    'type' => 'number',
                                    'options' => ['required', 'class' => 'font-18 text-center'],
                                ],
                                'label' => [
                                    'text' => 'عدد الغرف',
                                    'options' => [
                                        'class' => 'required',
                                    ],
                                ],
                            ]" />
                        </div><!-- bedrooms -->

                        <div class="col-6">
                            <x-form-group :properties="[
                                'input' => [
                                    'name' => 'bathrooms',
                                    'type' => 'number',
                                    'options' => ['required', 'class' => 'font-18 text-center'],
                                ],
                                'label' => [
                                    'text' => 'عدد الحمامات',
                                    'options' => [
                                        'class' => 'required',
                                    ],
                                ],
                            ]" />
                        </div><!-- bathrooms -->

                        <div class="col-6">
                            <x-form-group :properties="[
                                'input' => [
                                    'name' => 'area',
                                    'type' => 'number',
                                    'options' => ['required', 'class' => 'font-18 text-center'],
                                ],
                                'label' => [
                                    'text' => 'المساحة م²',
                                    'options' => [
                                        'class' => 'required',
                                    ],
                                ],
                            ]" />
                        </div><!-- area -->

                        <div class="col-6">
                            <x-dashboard.input-price :options="[
                                'name' => 'price',
                                'label_text' => 'السعر',
                                'required' => false,
                                'class' => 'text-center',
                            ]" />
                        </div><!-- price -->

                    </div><!-- end row -->

                    <button type="submit" class="btn btn-main btn-block mt-1">اضافة</button>

                </form><!-- End Form -->
            </x-panel-with-heading>

        </div><!-- end form -->

        <div class="col-xl-8 col-lg-6 col-md-8">


            <div class="box table-responsive">
                <table class="table table-inverse mb-0 text-center table-modern table-modern-xs">
                    <thead class="thead-inverse">
                        <tr>
                            <th>التحكم</th>
                            <th class=" text-center">صورة النموذج</th>
                            <th>اسم النموذج</th>
                            <th>المساحة</th>
                            <th>السعر</th>
                            <th>عدد الغرف</th>
                            <th>عدد الحمامات</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($row->units as $item)
                            <tr class="parents">

                                <td>
                                    <div class="d-flex justify-content-center">

                                        <button data-id="{{ $item->id }}" type="button"
                                            class="btn-edit-item btn btn-xs btn-soft-primary ml-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                <path
                                                    d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415" />
                                                <path d="M16 5l3 3" />
                                            </svg>
                                        </button>

                                        <x-dashboard.delete-form :action="route('properties.units.destroy', [$row, $item])" button-class="btn btn-xs btn-soft-danger"
                                            :name="$item->unit_number"  icon-only />

                                    </div>
                                </td><!-- actions -->

                                <td class="">
                                    @if ($item->image == '')
                                        -
                                    @else
                                        <img width="100px" height="40px" class="radius object-content"
                                            src="{{ smallAsset('properties/units/' . $item->image) }}" alt="">
                                    @endif
                                </td><!-- image -->

                                <td>{{ $item->unit_number }}</td>
                                <td>{{ $item->area }} م²</td>
                                <td>{{ number_format($item->price) }} {!! currency_icon('xs') !!}</td>
                                <td>{{ $item->bedrooms }} <small>غرفة</small></td>
                                <td>{{ $item->bathrooms }} <small>حمام</small></td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div><!-- box -->



        </div><!-- end grid 2 table -->

    </div>





@endsection
<x-dashboard.js :links="[
    [
        'link' => 'properties/units.js',
    ],
    [
        'link' => 'image-preview',
        'from' => 'components',
    ],
]" />
