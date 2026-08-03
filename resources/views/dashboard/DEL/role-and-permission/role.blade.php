@extends('dashboard.layouts.master')
@section('title', 'الأدوار')
@section('content')


    <x-dashboard.links-bar :links="[
        [
            'name' => 'الأدوار',
        ],
    ]" /> <!-- links bar --->


    <section id="roles" class="mb-5">
        <div class="row justify-content-center">

            <div class="col-xl-4">
                <div class="box">
                    <form action="{{ $actionUrl }}" method="POST" autocomplete="off">
                        <x-form-group :properties="[
                            'input' => [
                                'name' => 'name',
                                'value' => $nameVal,
                                'options' => [
                                    'placeholder' => 'مسوق الكتروني',
                                    'required',
                                ],
                            ],
                            'label' => [
                                'text' => 'اسم الدور',
                                'options' => [
                                    'class' => 'required',
                                ],
                            ],
                        ]" />

                        <input type="hidden" value="{{ request('id') }}" name="id">
                        @csrf
                        <button type="submit" class="btn btn-main px-4">{{ $btnText }}</button>
                    </form>
                </div><!-- Box Style -->
            </div><!-- Form Add New Role -->



            <div class="col-xl-8">
                <div class="box table-responsive">
                    <table class="table table-striped table-inverse table-bordered text-center">
                        <thead class="thead-inverse">
                            <tr>
                                <th>اسم الدور</th>
                                <th>تعديل الدور</th>
                                <th>صلاحيات الدور</th>
                                <th>حذف الدور</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($roles as $row)
                                @if ($row->name != 'owner')
                                    <tr>
                                        <td>{{ Str::ucfirst($row->name) }}</td>
                                        <td><a href="{{ adminUrl('roles?id=' . $row->id) }}"
                                                class="btn btn-main btn-sm">تعديل المسمي</a></td>
                                        <td><a href="{{ adminUrl("permissions/$row->id") }}"
                                                class="btn btn-success btn-sm">اضافة صلاحيات</a></td>
                                        <td>
                                            <form class="delete" action="{{ route('role-destroy') }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <input type="hidden" name="id"
                                                    value="{{ Crypt::encryptString($row->id) }}">
                                                <button type="submit"
                                                    class="btn btn-outline-danger btn-sm">حذف نهائي</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>


        </div><!-- Row -->
    </section><!-- Section -->

@endsection
