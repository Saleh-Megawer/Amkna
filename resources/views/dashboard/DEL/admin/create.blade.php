@extends('dashboard.layouts.master')
@section('title', 'انشاء مستخدم جديد')

@section('content')


    <x-dashboard.links-bar :links="[
        [
            'name' => 'المستخدمين',
            'link' => adminUrl('admins'),
        ],
        [
            'name' => 'انشاء مستخدم جديد',
        ],
    ]" />

    <section>

        <div class="row justify-content-center">
            <div class="col-md-7">
                <form class="ajax-post" action="{{ route('create-admin') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="box p-4">

                        <div class="row">

                            <div class="col-6">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'f_name',
                                        'options' => ['required'],
                                    ],
                                    'label' => [
                                        'text' => 'الاسم الأول',
                                        'options' => ['class' => 'required'],
                                    ],
                                ]" /><!-- f_name -->
                            </div>

                            <div class="col-6">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'l_name',
                                        'options' => ['required'],
                                    ],
                                    'label' => [
                                        'text' => 'الاسم الاخير',
                                        'options' => ['class' => 'required'],
                                    ],
                                ]" /><!-- l_name -->
                            </div>

                            <div class="col-12">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'email',
                                        'type' => 'email',
                                        'options' => ['required'],
                                    ],
                                    'label' => [
                                        'text' => 'البريد الإلكتروني',
                                        'options' => ['class' => 'required'],
                                    ],
                                ]" /><!-- email -->
                            </div>

                            <div class="col-9">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'password',
                                        'options' => ['required', 'class' => 'accept-random'],
                                    ],
                                    'label' => [
                                        'text' => 'كلمة المرور',
                                        'options' => ['class' => 'required'],
                                    ],
                                ]" /><!-- password -->
                            </div>

                            <div class="col-3 mt-2">
                                <button type="button" style="margin-top: 30px"
                                    class="generate-random btn btn-block btn-soft-info">عشوائية</button>
                            </div>


                            <div class="col-12">
                                <label class=" font-weight-600">الأدوار</label>
                                <div class="row">
                                    @foreach ($roles as $role)
                                        @if (canRole(owner()) || $role->name != owner())
                                            <div class="col-md-6 col-12">
                                                <div class="form-group mb-0">
                                                    <label class=" d-inline-block cursor-pointer">
                                                        <input class=" d-inline-block" type="checkbox" name="roles[]"
                                                            value="{{ $role->name }}">
                                                        {{ Str::headLine(Str::limit($role->name, 25))  }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>


                        </div> <!-- row -->

                    </div>

                    <button type="submit" class="btn btn-main px-4">إضافة جديد</button>

                </form>
            </div>
        </div>

    </section>


@endsection

<x-dashboard.js :links="[
    [
        'link' => 'admin/admins.js',
        'from' => 'pages',
        'type' => 'module',
    ],
    [
        'link' => 'generate-random-characters.js',
        'from' => 'components',
    ],
]" />
