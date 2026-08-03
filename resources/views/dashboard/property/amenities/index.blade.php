@extends('dashboard.layouts.master')
@section('title', 'مرافق الوحدات')
@section('content')

    <x-dashboard.links-bar :links="[
        [
            'name' => 'مرافق الوحدات',
        ],
    ]" />

    <section id="">
        <div class="row justify-content-center">

            @canany(['property_amenities_create', 'property_amenities_edit'])
                @if (isset($editRow['id']) || canPermission('property_amenities_create'))
                    <div class="col-lg-4 col-md-6">
                        <x-panel-with-heading title="{{ $formOption['panelTitle'] }}">
                            <form class="form" action="{{ $formOption['formAction'] }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                @isset($editRow['id'])
                                    <input type="hidden" name="id" value="{{ $editRow['id'] }}">
                                    @method('PATCH')
                                @endisset

                                @foreach (languages() as $key => $val)
                                    <x-form-group :properties="[
                                        'input' => [
                                            'name' => $key . '[name]',
                                            'type' => 'text',
                                            'value' => is_object($editRow) ? $editRow->translate($key)?->name : '',
                                            'options' => ['required'],
                                        ],
                                        'label' => [
                                            'text' => 'اسم المرفق ( ' . $val['name'] . ' )',
                                            'options' => [
                                                'class' => 'required',
                                            ],
                                        ],
                                    ]" />
                                @endforeach

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

            <div
                class="col-lg-8 col-md-6">
                <div class="box box-table px-0 pt-2 table-responsive">
                    <table class="table table-modern table-modern-sm table-inverse">
                        <thead class="thead-inverse">
                            <tr>
                                @canany(['property_amenities_edit', 'property_amenities_delete'])
                                    <th>التحكم</th>
                                @endcanany
                                <th>اسم المرفق</th>
                                <th>تاريخ الإضافة</th>
                                <th>اضيف بواسطة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $row)
                                <tr class="parents">

                                    @canany(['property_amenities_edit', 'property_amenities_delete'])
                                        <td>

                                            @can('property_amenities_edit')
                                                <a class="btn btn-xs btn-soft-primary" href="?edit={{ $row->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                        <path
                                                            d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415" />
                                                        <path d="M16 5l3 3" />
                                                    </svg>
                                                </a>
                                            @endcan

                                            @can('property_amenities_delete')
                                                <form class="ajax-delete d-inline-block" action="{{ $destroyRoute }}"
                                                    method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <input type="hidden" class="id" name="id" value="{{ $row->id }}">
                                                    <button type="submit" data-delete="هل انت متأكد من حذف : {{ $row->name }}"
                                                        class="btn-delete-attech btn-xs btn btn-soft-danger">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

                                    <td>{{ $row->name }}</td>
                                    <td>{{ parseTime($row->created_at) }}</td>
                                    <td>{!! $row->admin != null ? $row->admin->full_name : "<small class='text-muted'>لا يوجد</small>" !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>

@endsection
