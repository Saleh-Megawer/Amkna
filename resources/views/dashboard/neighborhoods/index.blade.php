@extends('dashboard.layouts.master')
@section('title', 'عرض الأحياء')
@section('content')

    <x-dashboard.links-bar :links="[
        [
            'name' => 'الأحياء',
        ],
    ]" /><!-- links bar -->


    <section id="">
        <div class="row justify-content-center">

            @canany(['neighborhood_create', 'neighborhood_edit'])
                @if (isset($editRow['id']) || canPermission('neighborhood_create'))
                    <div class="col-xl-4 col-lg-6 col-md-4">
                        <x-panel-with-heading title="{{ $formOption['panelTitle'] }}">
                            <form class="form" action="{{ $formOption['formAction'] }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                @isset($editRow['id'])
                                    <input type="hidden" name="id" value="{{ $editRow['id'] }}">
                                    @method('PATCH')
                                @endisset

                                <div class="form-row">
                                    @foreach (languages() as $key => $val)
                                        <div class="col-12">
                                            <x-form-group :properties="[
                                                'input' => [
                                                    'name' => $key . '[name]',
                                                    'type' => 'text',
                                                    'value' => is_object($editRow)
                                                        ? $editRow->translate($key)?->name
                                                        : '',
                                                    'options' => ['required'],
                                                ],
                                                'label' => [
                                                    'text' => 'اسم المنطقة ( ' . $val['name'] . ' )',
                                                    'options' => [
                                                        'class' => 'required',
                                                    ],
                                                ],
                                            ]" />
                                        </div>
                                    @endforeach
                                </div>

                                <x-form-group :properties="[
                                    'select' => [
                                        'name' => 'city_id',
                                        'list' => $cities,
                                        'selected' => isset($editRow['city_id']) ? $editRow['city_id'] : '',
                                        'options' => ['required', 'class' => 'font-16', 'placeholder' => 'اختر'],
                                    ],
                                    'label' => [
                                        'text' => 'المنطقة تابعة لمحافظة ؟',
                                        'options' => [
                                            'class' => 'required',
                                        ],
                                    ],
                                ]" />

                                @isset($editRow['image'])
                                    @if ($editRow['image'] != '')
                                        <img class="mb-2 radius object-content"
                                            src="{{ smallAsset('neighborhoods/' . $editRow['image']) }}"
                                            width="100px" height="60px" alt="">
                                    @endif
                                @endisset

                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'image',
                                        'type' => 'file',
                                        'options' => [
                                            'class' => 'input-img',
                                            'accept' => 'image/*',
                                        ],
                                    ],
                                    'label' => [
                                        'text' => 'صورة الحي',
                                    ],
                                ]" />

                                <div class="form-row">
                                    <div class="{{ isset($editRow['id']) ? 'col-8' : 'col-12' }}">
                                        <button type="submit" class="btn btn-main btn-block btn-block ">
                                            {{ $formOption['submitButton'] }}
                                        </button>
                                    </div>

                                    <div class="{{ isset($editRow['id']) ? 'col-4' : 'd-none' }}">
                                        <a href="{{ url()->current() }}" class="btn btn-soft-main btn-block">إلغاء</a>
                                    </div>
                                </div>

                            </form>
                        </x-panel-with-heading>
                    </div>
                @endif
            @endcanany

            <div class="col-xl-8 col-lg-6 col-md-8">

                <div class="box box-table table-responsive">
                    <table class="table table-modern table-inverse">
                        <thead class="thead-inverse">
                            <tr>
                                @canany(['neighborhood_edit', 'neighborhood_delete'])
                                    <th>التحكم</th>
                                @endcanany
                                <th>الاسم</th>
                                <th>تابع إلي مدينة</th>
                                <th>تاريخ الإضافة</th>
                                <th>اضيف بواسطة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $row)
                                <tr class="parents">

                                    @canany(['neighborhood_edit', 'neighborhood_delete'])
                                        <td>

                                            @can('neighborhood_edit')
                                                <a class="btn btn-xs btn-soft-primary" href="?edit={{ $row->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icon-tabler-edit">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                        <path
                                                            d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415" />
                                                        <path d="M16 5l3 3" />
                                                    </svg>
                                                </a>
                                            @endcan

                                            @can('neighborhood_delete')
                                                <form class="ajax-delete d-inline-block"
                                                    action="{{ route('neighborhoods-destroy') }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <input type="hidden" class="id" name="id" value="{{ $row->id }}">
                                                    <button type="submit" data-delete="هل انت متأكد من حذف : {{ $row->name }}"
                                                        class="btn-delete-attech btn-xs btn btn-soft-danger">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="icon icon-tabler icon-tabler-trash">
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

                                        </td>
                                    @endcanany

                                    <td>
                                        @foreach (languages() as $key => $val)
                                            {{ $row->translate($key)?->name }}
                                        @endforeach
                                    </td>

                                    <td>{{ $row->city->name }}</td>
                                    <td>{{ parseTime($row->created_at) }}</td>
                                    <td>{!! $row->by != null ? $row->by->full_name : "<small class='text-muted'>لا يوجد</small>" !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 mb-5 pb-4">
                    <x-paginate :data="$rows" />
                </div>

            </div>

        </div>
    </section>

@endsection

<x-dashboard.js :links="[
    [
        'link' => 'image-preview',
        'from' => 'components',
    ],
]" />
