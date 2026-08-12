@extends('dashboard.layouts.master')
@section('title', 'واجهات الوحدات')
@section('content')

    <x-dashboard.links-bar :links="[
        [
            'name' => 'واجهات الوحدات',
        ],
    ]" /><!-- links bar -->


    <section id="">
        <div class="row">

            <div class="col-xl-4 col-lg-6 col-md-12">
                <x-panel-with-heading title="{{ $formOption['panelTitle'] }}">
                    <form class=" form" action="{{ $formOption['formAction'] }}" method="POST" enctype="multipart/form-data">
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
                                            'value' => is_object($editRow) ? $editRow->translate($key)?->name : '',
                                            'options' => ['required'],
                                        ],
                                        'label' => [
                                            'text' => 'اسم الواجهة  ( ' . $val['name'] . ' )',
                                            'options' => [
                                                'class' => 'required',
                                            ],
                                        ],
                                    ]" />
                                </div>
                            @endforeach
                        </div>



                        <div class="form-row">

                            <div class="{{ isset($editRow['id']) ? 'col-8' : 'col-12' }}">
                                <button type="submit"
                                    class="btn btn-main btn-block btn-block ">{{ $formOption['submitButton'] }}</button>
                            </div>

                            <div class="{{ isset($editRow['id']) ? 'col-4' : 'd-none' }}">
                                <a href="{{ url()->current() }}" class="btn btn-soft-main btn-block">إلغاء</a>
                            </div>

                        </div>

                    </form>
                </x-panel-with-heading>
            </div>

            <div class="col-xl-8 col-lg-6 col-md-12">
                <div class="box box-table table-responsive">
                    <table class="table table-modern table-inverse">
                        <thead class="thead-inverse">
                            <tr>
                                <th>التحكم</th>
                                <th>الوجهة</th>
                                <th>تاريخ الإضافة</th>
                                <th>اضيف بواسطة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $row)
                                <tr class="parents">
                                    <td>
                                        <a class="btn btn-sm btn-soft-primary" href="?edit={{ $row->id }}"><i
                                                class=" fa fa-edit"></i>
                                        </a>
                                        <form class="ajax-delete d-inline-block"
                                            action="{{ route('properties.facades.destroy') }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <input type="hidden" class="id" name="id" value="{{ $row->id }}">
                                            <button type="submit" data-delete="هل انت متأكد من حذف : {{ $row->name }}"
                                                class="btn-delete-attech  btn-sm btn btn-soft-danger"><i
                                                    class=" fa fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>

                                    <td>
                                        @foreach (languages() as $key => $val)
                                            {{ $row->translate($key)?->name }}
                                        @endforeach
                                    </td>

                                    <td>{{ parseTime($row->created_at) }}</td>
                                    <td>{!! $row->by != null ? $row->by->full_name : "<small class='text-muted'>لا يوجد</small>" !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div><!-- row -->
    </section><!-- section -->

@endsection
