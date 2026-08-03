@extends('dashboard.layouts.master')
@section('title', 'وسائل الراحة')
@section('content')

    <x-dashboard.links-bar :links="[
        [
            'name' => 'وسائل الراحة',
        ],
    ]" /><!-- links bar -->

    <section id="">
        <div class="row">

            @can('property_amenities_create')
            <div class="col-lg-3 col-md-4">
                <x-panel-with-heading title="{{ $formOption['panelTitle'] }}">
                    <form class=" form" action="{{ $formOption['formAction'] }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @isset($editRow['id'])
                            <input type="hidden" name="id" value="{{ $editRow['id'] }}">
                            @method('PATCH')
                        @endisset

                        <x-form-group :properties="[
                            'input' => [
                                'name' => 'name',
                                'type' => 'text',
                                'value' => isset($editRow['name']) ? $editRow['name'] : '',
                                'options' => ['required'],
                            ],
                            'label' => [
                                'text' => 'تسمية الراحة',
                                'options' => ['class' => 'required'],
                            ],
                        ]" /><!-- name -->

                        <button type="submit" class="btn btn-main btn-block ">{{ $formOption['submitButton'] }}</button>
                    </form>
                </x-panel-with-heading>

                @isset($editRow['id'])
                    <a href="{{ url()->current() }}" class="mb-4 text-danger">إلغاء التعديل</a>
                @endisset
            </div>
            @endcan

            <div class="@can('property_amenities_create'){{ 'col-lg-9 col-md-8' }} @else {{ 'col-12' }} @endcan">
                <div class="box px-0 pt-2 table-responsive">
                    <table class="table table-modern table-modern-sm table-inverse">
                        <thead class="thead-inverse">
                            <tr>
                                @canany(['property_amenities_edit','property_amenities_delete'])
                                    <th>التحكم</th>
                                @endcanany
                                <th>تسمية الراحة</th>
                                <th>تاريخ الإضافة</th>
                                <th>اضيف بواسطة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $row)
                                <tr class="parents">
                                    @canany(['property_amenities_edit','property_amenities_delete'])
                                        <td>
                                            @can('property_amenities_edit')
                                                <a class="btn btn-sm btn-soft-primary" href="?edit={{ $row->id }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endcan

                                            @can('property_amenities_delete')
                                                <span class="text-secondary">|</span>
                                                <form class="ajax-delete d-inline-block" action="{{ $destroyRoute }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <input type="hidden" class="id" name="id" value="{{ $row->id }}">
                                                    <button type="submit"
                                                            data-delete="هل انت متأكد من حذف : {{ $row->name }}"
                                                            class="btn-delete-attech btn-sm btn btn-soft-danger">
                                                        <i class="fa fa-trash-alt"></i>
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

        </div><!-- row -->
    </section><!-- section -->

@endsection
