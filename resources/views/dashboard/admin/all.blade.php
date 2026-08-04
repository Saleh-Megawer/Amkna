@extends('dashboard.layouts.master')
@section('title', 'المشرفين')

<x-dashboard.css link="admin/admins" />

@section('content')

    @php
        $addBtn = null;
    @endphp
    @can('create_admin')
        @php
            $addBtn = [
                'name' => 'إضافة مستخدم',
                'class' => 'btn-main',
                'options' => [
                    'data-toggle' => 'modal',
                    'data-target' => '#createModel',
                    'type' => 'button',
                ],
            ];
        @endphp
    @endcan

    <x-dashboard.links-bar :links="[
        [
            'link' => adminUrl('admins'),
        ],
    ]" :buttons="[
        $addBtn,
        [
            'name' => 'بحث',
            'class' => 'btn btn-soft-main',
            'options' => [
                'data-toggle' => 'modal',
                'data-target' => '.bd-example-modal-lg',
                'type' => 'button',
            ],
        ],
    ]" />

    <section id="admins">
        <div class="row">

            @foreach ($admins as $row)
                <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-4">
                    <div class="box admin-card p-0">

                        <div class="cover">
                            @if ($row->cover == null || !file_exists(smallPath($coverPath . '/' . $row->cover)))
                                <img class="w-100 object-cover"
                                    src="{{ asset('dashboard/images/admin/covers/small/' . rand(1, 7) . '.jpg') }}"
                                    alt="">
                            @else
                                <img class="w-100 object-cover" src="{{ smallAsset($coverPath . '/' . $row->cover) }}"
                                    alt="">
                            @endif
                        </div><!-- cover -->

                        <div class="p-4">

                            <div class="avatar p-1 rounded-circle text-center">
                                @if ($row->avatar == null || !file_exists(smallPath($avatarPath . '/' . $row->avatar)))
                                    <span
                                        class=" font-28">{{ mb_substr($row->f_name, 0, 1) . mb_substr($row->l_name, 0, 1) }}</span>
                                @else
                                    <img class="rounded-circle  object-cover w-100 h-100"
                                        src="{{ smallAsset($avatarPath . '/' . $row->avatar) }}" alt="">
                                @endif
                            </div><!-- avatar -->


                            <div class="info text-center mt-5">

                                @can('show_another_admins_profile')
                                    <a href="{{ adminUrl('profile/show/' . $row->id) }}">
                                        <h6 class="admin-name font-18 text-center d-inline text-primary">
                                            {{ $row->f_name . ' ' . $row->l_name }}</h6>
                                    </a>
                                @else
                                    <h6 class="admin-name font-18 text-center d-inline text-black">
                                        {{ $row->f_name . ' ' . $row->l_name }}
                                    </h6>
                                @endcan


                                @if ($row->is_marketer_request)
                                    <small class="badge badge-success badge-md font-11 status-badge">
                                        طلب مسوق جديد
                                    </small>
                                @elseif ($row->status == 0)
                                    <small class="badge badge-soft-danger badge-md font-11 status-badge">
                                        الحساب محظور
                                    </small>
                                @endif


                                <small class=" text-second d-block">
                                    @if ($row->job == null)
                                        لم يتم إدخال المسمى الوظيفي
                                    @else
                                        {{ $row->job }}
                                    @endif
                                </small>

                            </div><!-- info -->


                            <div class=" text-center mt-3">
                                @forelse ($row->roles as $role)
                                    <span class=" badge badge-light border">{{ Str::headLine($role->name) }}</span>
                                @empty
                                    <span class=" badge badge-warning ">لا يوجد أدوار</span>
                                @endforelse
                            </div>

                            <small class="last-seen-status d-block text-center mt-2" @if($row->last_seen) title="{{ $row->last_seen->translatedFormat('d F Y - h:i A') }}" @endif>
                                <span class="last-seen-dot {{ $row->is_online ? 'online' : 'offline' }}"></span>
                                {{ $row->last_seen_label }}
                            </small>

                        </div><!-- padding -->

                        @canany(['activate_deactivate_admin'])
                            @if (!in_array(owner(), $row->roles->pluck('name')->toArray()) && $row->id != adminId())
                                <div class="controls">
                                    <div class="btn-group">

                                        <button class="dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-dots">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 12a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                <path d="M11 12a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                <path d="M18 12a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                            </svg>
                                        </button>

                                        <div class="dropdown-menu dropdown-menu-right dropdown-basic"
                                            aria-labelledby="triggerId">

                                            @role(owner())
                                                <a class="dropdown-item font-14 text-second"
                                                    href="{{ adminUrl('admins/edit/' . $row->id) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-user-edit">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5" />
                                                        <path
                                                            d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39" />
                                                    </svg>
                                                    تعديل
                                                </a>
                                            @endrole

                                            @if ($row->status > 0)
                                                @can('activate_deactivate_admin')
                                                    <form class="form-status" action="{{ route('closed-admin-account') }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="id" value="{{ $row->id }}">
                                                        <button type="submit"
                                                            class="btn-change-status dropdown-item font-14 text-second">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-ban">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                                <path d="M5.7 5.7l12.6 12.6" />
                                                            </svg>
                                                            حظر الحساب
                                                        </button>
                                                    </form>
                                                @endcan
                                            @else
                                                @can('create_admin')
                                                    <form class="form-status" action="{{ route('active-admin-account') }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="id" value="{{ $row->id }}">
                                                        <button type="submit"
                                                            class="btn-change-status dropdown-item font-14 text-second">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-lock-open">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path
                                                                    d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2l0 -6" />
                                                                <path d="M11 16a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                                <path d="M8 11v-5a4 4 0 0 1 8 0" />
                                                            </svg>
                                                            إلغاء حظر الحساب
                                                        </button>
                                                    </form>
                                                @endcan
                                            @endif

                                        </div><!-- End Menu -->

                                    </div>
                                </div><!-- controls -->
                            @endif
                        @endcanany

                    </div><!-- box -->
                </div><!-- admin card -->
            @endforeach

        </div><!-- row -->
    </section><!-- admins -->

    <!-- Search Modal -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">بحث</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <form id="form-search" action="{{ route('admin-search') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-9 pr-remove pl-remove">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'name',
                                        'options' => [
                                            'placeholder' => 'الاسم',
                                            'class' => 'input-search',
                                        ],
                                    ],
                                ]" />
                            </div>
                            <div class="col-3">
                                <button type="submit" class="btn btn-search btn-main btn-block"><i
                                        class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </div>

                    </form>

                    <div id="response-data"></div><!-- response from js -->

                </div>

            </div>
        </div>
    </div>

    @can('create_admin')
        <!-- Create Model -->
        <div class="modal fade" id="createModel" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">إضافة مشرف</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    {{-- <form class="ajax-post" action="{{ route('create-admin') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">

                            <div class="form-row">

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



                                <div class="col-sm-9 col-7">
                                    <div class=" input-normal-style">
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
                                </div>

                                <div class="col-sm-3 col-5 mt-2">
                                    <button type="button" class="generate-random btn-block btn btn-soft-main mt-4">
                                        عشوائية
                                    </button>
                                </div>

                                <div class="col-12">
                                    <div class=" input-normal-style">
                                        <label class=" font-weight-600">الأدوار</label>
                                        <div class="form-row">
                                            @foreach ($roles as $role)
                                                <div class="col-md-6 col-12">

                                                    <div class="form-group mb-0">
                                                        <label class=" d-inline-block cursor-pointer">
                                                            <input class=" d-inline-block" type="checkbox" name="roles[]"
                                                                value="{{ $role->name }}">
                                                            {{ Str::headLine(Str::limit($role->name, 25)) }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            </div> <!-- row -->

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-main btn-block">إضافة المشرف</button>
                        </div>
                    </form> --}}

                    <div class=" modal-body">
                        @include('dashboard.admin.partials.form-create-admin')
                    </div>

                </div>
            </div>
        </div>
    @endcan

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
