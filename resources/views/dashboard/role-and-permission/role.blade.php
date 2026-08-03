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
                        <x-form-group class="mb-1" :properties="[
                            'input' => [
                                'name' => 'name',
                                'value' => $nameVal,
                                'options' => [
                                    'placeholder' => 'مثال : مسؤول مبيعات',
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
                        <small>اسم الدور او الوظيفة اكتب مسمي الوظيفي لنقوم بتحديد صلاحيات محددة لذلك الدور</small>
                        <input type="hidden" value="{{ request('id') }}" name="id">
                        @csrf
                        <button type="submit" class="btn btn-main px-4 mt-3">{{ $btnText }}</button>
                    </form>
                </div><!-- Box Style -->
            </div><!-- Form Add New Role -->



            <div class="col-xl-8">
                <div class="box table-responsive">
                    <table class="table table-modern table-inverse table-modern-sm">
                        <thead class="thead-inverse">
                            <tr>
                                <th>الإجراءات</th>
                                <th>اسم الدور ( المسمي الوظيفي )</th>
                                <th>عدد الصلاحيات</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($roles as $row)
                                <tr>
                                    <td class=" d-flex">

                                        <a href="{{ adminUrl("permissions/$row->id") }}" class="btn tip btn-success btn-xs"
                                            title="اضافة صلاحيات">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 5l0 14" />
                                                <path d="M5 12l14 0" />
                                            </svg>
                                        </a>

                                        @unless (in_array($row->name, $protected_roles))
                                            <a href="{{ adminUrl('roles?id=' . $row->id) }}"
                                                class="btn mx-2 btn-soft-primary btn-xs tip" title="تعديل المسمي">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                    <path
                                                        d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415" />
                                                    <path d="M16 5l3 3" />
                                                </svg>
                                            </a>
                                        @endunless

                                        @unless (in_array($row->name, $protected_roles))
                                            <form class="delete" action="{{ route('role-destroy') }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <input type="hidden" name="id"
                                                    value="{{ Crypt::encryptString($row->id) }}">
                                                <button type="submit" title="حذف نهائي"
                                                    class="btn tip btn-outline-danger btn-xs">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                                        @endunless

                                    </td>
                                    <td>{{ Str::ucfirst($row->name) }}</td>
                                    <td>{{ $row->permissions_count }} / {{ $totalPermissions }}</td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>


        </div><!-- Row -->
    </section><!-- Section -->

@endsection
