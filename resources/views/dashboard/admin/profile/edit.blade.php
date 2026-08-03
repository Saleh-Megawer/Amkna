@extends('dashboard.layouts.master')
@section('title', dbTrans('admin.Profile edit page title'))

<x-dashboard.css link='admin/profile/edit' />

@section('body')

    <header id="header" class="bg" style="background-image: url({{ $coverPath }})">
        <div class="overlay overlay-black"></div>
        <section id="banner"></section>

        <form id="form-change-cover" class=" ajax-post" action="{{ route('update-profile-cover') }}" method="POST"
            enctype="multipart/form-data">
            <label id="btn-choose-cover" class="btn btn-soft-light" for="input-cover"><i class="fa-regular fa-images"></i>
                {{ dbTrans('admin.Change Cover') }}
            </label>
            @csrf
            @method('PATCH')
            <!-- Start Input ID -->
            <x-form-group class="my-0" :properties="$inputId" />
            <!-- End Input ID -->

            <input type="file" class="input-bg d-none" name="cover" id="input-cover" required>
            <div class="controls d-none">
                <div id="top" class="btn btn-warning">{{ dbTrans('admin.Top') }}</div>
                <div id="bottom" class="btn btn-warning">{{ dbTrans('admin.Bottom') }}</div>
            </div><!-- This Element Not Used Yet -->
            <button type="submit" class="btn-main btn display-none">{{ dbTrans('admin.Save') }}</button>
        </form>
    </header>


    <main id="edit">
        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">

                    <section id="avatar">
                        <div class="box shadow-none text-center py-4">


                            <div class="image bg-main d-inline-block w128 h128 rounded-circle">
                                <img class="w-100 h-100 object-cover p-1 rounded-circle img" src="{{ $avatarPath }}"
                                    alt="">
                                <div class=" input-normal-style">
                                    <label style="top: 0px" id="btn-choose-profile-img" for="input-profile-avatar"
                                        class=" rounded-circle font-14">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-camera">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                                            <path d="M9 13a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                        </svg>
                                    </label>
                                </div>
                            </div><!-- image-->

                            <h5 class="mt-3 mb-0 first-info text-center">
                                <span class="name text-main">
                                    <a href="{{ adminUrl('profile/show/' . $row->id) }}">
                                        <span class="f_name">{{ $row->f_name }}</span>
                                        <span class="l_name">{{ $row->l_name }}</span>
                                        <br>
                                        <span class="job font-12 text-secondary">{{ $row->job }}</span>
                                    </a>
                                </span>
                            </h5><!-- first-info -->

                            <form class="ajax-post" action="{{ route('update-profile-avatar') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <!-- Start Input ID -->
                                <x-form-group class="my-0" :properties="$inputId" />
                                <!-- End Input ID -->

                                <input type="file" id="input-profile-avatar" class="input-img d-none" name="avatar"
                                    required>

                                <button id="btn-update-avatar" type="submit"
                                    class="display-none btn btn-main btn-sm btn-block mt-2">{{ dbTrans('admin.Update') }}</button>
                            </form><!-- update avatar -->


                        </div><!-- box -->

                        @php
                            $adminId = $row->id;
                            $currentAdminId = adminAuth('id');

                            $isOwner = canRole(owner());
                            $isSelfDelete = $adminId == $currentAdminId;
                        @endphp

                        @if (($isOwner && !$isSelfDelete) || (!$isOwner && $isSelfDelete))
                            <form class="delete d-inline-block" action="{{ route('deleteAdmin') }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <!-- Start Input ID -->
                                <x-form-group class="my-0" :properties="$inputId" />
                                <!-- End Input ID -->
                                <button type="submit" data-delete="هل انت متأكد من حذف : {{ $row->full_name }}"
                                    class="btn-delete-attech font-16 px-4 py-2 btn btn-soft-danger">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7l16 0" />
                                        <path d="M10 11l0 6" />
                                        <path d="M14 11l0 6" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>

                                    حذف المشرف
                                </button>
                            </form>
                        @endif

                    </section><!-- avatar -->

                    <section id="portfolio" class=" d-none">

                        <x-panel-with-heading title="{{ dbTrans('admin.Portfolio') }}">

                            <!-- Start Check IF Have Links , For Set Button Update  -->
                            @php
                                $links = '';
                                foreach ($portfolio as $port) {
                                    if ($links == null && $port != null) {
                                        $links .= $port;
                                    }
                                }
                            @endphp

                            @if ($links != null)
                                <form class="ajax-post" action="{{ route('portfolio-update') }}" method="POST">
                                    @method('PATCH')
                                    @csrf
                                    <!-- Start Input ID -->
                                    <x-form-group class="my-0" :properties="$inputId" />
                                    <!-- End Input ID -->

                                    <div class="display-social-media">
                                        @foreach (socialMedia() as $val)
                                            @if ($portfolio[$val['name_en']] != null)
                                                <div style="background-color: {{ $val['color'] }}" class="icon">
                                                    {!! $val['icon'] !!}
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" name="{{ $val['name_en'] }}"
                                                        value="{{ $portfolio[$val['name_en']] }}"
                                                        placeholder="{{ Str::headline($val['name_en']) }}"
                                                        class="form-control font-13">
                                                </div>
                                            @endif
                                        @endforeach
                                        <button type="submit"
                                            class="btn-update-port btn btn-main btn-sm">{{ dbTrans('admin.Update') }}</button>
                                        <div class="clearfix"></div>
                                    </div>

                                </form><!-- form -->
                            @endif
                        </x-panel-with-heading>

                        <!-- Button trigger modal -->
                        <button id="btn-portfolio-open-model" type="button" class="btn btn-soft-main font-13 px-1 py-0"
                            data-toggle="modal" data-target="#portfolioModel">
                            <i class="fa-solid fa-plus"></i> {{ dbTrans('admin.Add') }}
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="portfolioModel" tabindex="-1" role="dialog"
                            aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ dbTrans('admin.Portfolio Add') }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form class="ajax-post" action="{{ route('portfolio-update') }}" method="POST">
                                        <div class="modal-body">
                                            @method('PATCH')
                                            @csrf

                                            <div class="form-group">
                                                <select name="select-social-media" id="select-social-media">
                                                    <option disabled selected>{{ dbTrans('admin.Choose') }}</option>
                                                    @foreach (socialMedia() as $val)
                                                        @if ($portfolio[$val['name_en']] == null)
                                                            <option value="{{ $val['name_en'] }}">
                                                                {{ Str::headline($val['name_en']) }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div><!-- social -->

                                            <x-form-group :properties="[
                                                'input' => [
                                                    'type' => 'url',
                                                    'name' => '',
                                                    'options' => [
                                                        'placeholder' => '',
                                                        'class' => 'display-none input-social-media-url',
                                                    ],
                                                ],
                                            ]" />

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">{{ dbTrans('admin.Close') }}</button>
                                            <button type="submit"
                                                class="btn btn-primary">{{ dbTrans('admin.Save') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </section><!-- Portfolio -->

                </div><!-- Grid 1 -->


                <div class="col-xl-8 col-lg-6 col-md-12 col-sm-12">
                    <section id="profile-details">
                        <div class="box shadow-none mb-5 p-0">

                            <div class="box-head mb-2">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">

                                    <li class="nav-item">
                                        <a class="nav-link active" id="personal-data-tab" data-toggle="tab"
                                            href="#personal-data" role="tab" aria-controls="personal-data"
                                            aria-selected="true">{{ dbTrans('admin.Personal Data') }}</a>
                                    </li><!-- Personal Data -->

                                    <li class="nav-item">
                                        <a class="nav-link" id="change-password-tab" data-toggle="tab"
                                            href="#change-password" role="tab" aria-controls="change-password"
                                            aria-selected="false">{{ dbTrans('admin.Password') }}</a>
                                    </li><!-- Change Password -->


                                    <li class="nav-item">
                                        <a class="nav-link" id="roles-tab" data-toggle="tab" href="#roles"
                                            role="tab" aria-controls="roles" aria-selected="false">الأدوار</a>
                                    </li><!-- Change Password -->


                                </ul>
                            </div><!-- box head -->

                            <div class="box-body py-3">

                                <div class="tab-content" id="myTabContent">

                                    <div class="tab-pane fa_de show active" id="personal-data" role="tabpanel"
                                        aria-labelledby="personal-data-tab">
                                        <form class="ajax-post" action="{{ route('update-personal-data') }}"
                                            method="post">
                                            <!-- Start Input ID -->
                                            <x-form-group class="my-0" :properties="$inputId" />
                                            <!-- End Input ID -->

                                            @csrf
                                            @method('PATCH')

                                            <div class="row">

                                                <div class="col-md-3 col-6">
                                                    <x-form-group :properties="[
                                                        'input' => [
                                                            'type' => 'text',
                                                            'name' => 'f_name',
                                                            'value' => $row->f_name,
                                                            'options' => ['required', 'maxlength' => 20],
                                                        ],
                                                        'label' => [
                                                            'text' => dbTrans('admin.First Name'),
                                                            'options' => [
                                                                'class' => 'required',
                                                            ],
                                                        ],
                                                    ]" />
                                                </div><!-- f_name -->

                                                <div class="col-md-3 col-6">
                                                    <x-form-group :properties="[
                                                        'input' => [
                                                            'type' => 'text',
                                                            'name' => 'l_name',
                                                            'value' => $row->l_name,
                                                            'options' => ['required', 'maxlength' => 20],
                                                        ],
                                                        'label' => [
                                                            'text' => dbTrans('admin.Last Name'),
                                                            'options' => [
                                                                'class' => 'required',
                                                            ],
                                                        ],
                                                    ]" />
                                                </div><!-- l_name -->

                                                <div class="col-md-6">

                                                    @php
                                                        $border = '';
                                                        if ($admin->email_verified == 0) {
                                                            $border = 'border-danger';
                                                        }
                                                    @endphp

                                                    <x-form-group class="mb-1" :properties="[
                                                        'input' => [
                                                            'type' => 'email',
                                                            'name' => 'email',
                                                            'value' => $row->email,
                                                            'options' => ['required', 'class' => $border],
                                                        ],
                                                        'label' => [
                                                            'text' => dbTrans('admin.email'),
                                                            'options' => [
                                                                'class' => 'required',
                                                            ],
                                                        ],
                                                    ]" />

                                                    @if ($admin->email_verified == 0)
                                                        <div class="mb-2 text-danger">
                                                            {{ dbTrans('admin.This Email Not Verified Yet') }}
                                                            @if ($row->id == adminId())
                                                                <!-- WHAT IS HERE !!!!!!!!!!!!!!!!!!!! -->
                                                            @endif
                                                            <button type="button"
                                                                data-id="{{ Crypt::encryptString($row->id) }}"
                                                                id="btn-verify-email" class="text-primary">
                                                                {{ dbTrans('admin.Check My Email') }}
                                                            </button>
                                                        </div>
                                                    @endif

                                                </div><!-- email -->

                                                <div class="col-md-6">
                                                    <x-form-group :properties="[
                                                        'input' => [
                                                            'type' => 'number',
                                                            'name' => 'phone',
                                                            'value' => $row->phone,
                                                            'options' => ['required'],
                                                        ],
                                                        'label' => [
                                                            'text' => dbTrans('admin.Phone Number'),
                                                            'options' => [
                                                                'class' => 'required',
                                                            ],
                                                        ],
                                                    ]" />
                                                </div><!-- phone -->

                                                <div class="col-md-6">
                                                    <x-form-group :properties="[
                                                        'input' => [
                                                            'name' => 'job',
                                                            'value' => $row->job,
                                                            'options' => ['required'],
                                                        ],
                                                        'label' => [
                                                            'text' => dbTrans('admin.Job Title'),
                                                            'options' => ['class' => 'required'],
                                                        ],
                                                    ]" />
                                                </div><!-- job -->

                                                <div class="col-md-6 d-none">
                                                    <x-form-group :properties="[
                                                        'input' => [
                                                            'name' => 'skills',
                                                            'value' => 'Js Bootstrap Php Laravel Css',
                                                            'options' => ['required'],
                                                        ],
                                                        'label' => [
                                                            'text' => dbTrans('admin.Skills'),
                                                    
                                                            'options' => ['class' => 'required'],
                                                        ],
                                                    ]" />
                                                </div><!-- skills -->

                                                <div class="col-md-6 d-none">
                                                    <x-form-group :properties="[
                                                        'input' => [
                                                            'name' => 'country',
                                                            'value' => 'مصر',
                                                            'options' => ['required'],
                                                        ],
                                                        'label' => [
                                                            'text' => dbTrans('admin.Country'),
                                                            'options' => [
                                                                'class' => 'required',
                                                            ],
                                                        ],
                                                    ]" />
                                                </div><!-- country -->

                                                <div class="col-md-6 d-none">
                                                    <x-form-group :properties="[
                                                        'input' => [
                                                            'name' => 'city',
                                                            'value' => 'القاهرة',
                                                            'options' => ['required'],
                                                        ],
                                                        'label' => [
                                                            'text' => dbTrans('admin.City'),
                                                            'options' => [
                                                                'class' => 'required',
                                                            ],
                                                        ],
                                                    ]" />
                                                </div><!-- city -->

                                                <div class="col-md-4 d-none">
                                                    <x-form-group :properties="[
                                                        'input' => [
                                                            'name' => 'zip_code',
                                                            'value' => 111,
                                                        ],
                                                        'label' => [
                                                            'text' => dbTrans('admin.Zip Code'),
                                                        ],
                                                    ]" />
                                                </div><!-- zip_code -->

                                                <div class="col-md-12">
                                                    <x-form-group :properties="[
                                                        'textarea' => [
                                                            'name' => 'about',
                                                            'value' => $row->about,
                                                            'options' => ['required', 'rows' => 5],
                                                        ],
                                                        'label' => [
                                                            'text' => dbTrans('admin.About'),
                                                            'options' => [
                                                                'class' => 'required',
                                                            ],
                                                        ],
                                                    ]" />
                                                </div><!-- about -->

                                            </div><!-- row -->


                                            <div class="custom-control pl-2 custom-switch custom-switch-rtl pt-2">
                                                <input type="checkbox" class="custom-control-input sr-only"
                                                    id="is_available" name="is_available" value="1"
                                                    @checked($row->is_available)>
                                                <label class="custom-control-label font-16 bg-transparent"
                                                    for="is_available">
                                                    متاح للتوظيف <small class=" text-muted">(ازالة هذه الاشارة سيخفي الحساب استقبال الطلبات والإهتمامات)</small>
                                                </label>
                                            </div>


                                            <div class="buttons-update">
                                                <button type="submit"
                                                    class="btn btn-main">{{ dbTrans('admin.Update') }}</button>
                                            </div><!-- Button Update -->

                                        </form><!-- from -->
                                    </div><!-- Personal Data -->

                                    <div class="tab-pane fa_de " id="change-password" role="tabpanel"
                                        aria-labelledby="change-password-tab">

                                        @if (canRole(owner()) && $row->id != adminId())
                                            <form class="ajax-post" action="{{ route('change-admin-password') }}"
                                                method="post">
                                                @csrf
                                                @method('PATCH')

                                                <!-- Start Input ID -->
                                                <x-form-group class="my-0" :properties="$inputId" />
                                                <!-- End Input ID -->


                                                <div class="owner-update-password">
                                                    <div class=" input-normal-style">
                                                        <x-form-group :properties="[
                                                            'input' => [
                                                                'name' => 'password',
                                                                'options' => ['required', 'class' => 'accept-random'],
                                                            ],
                                                            'label' => [
                                                                'text' => dbTrans('admin.New Password'),
                                                                'options' => [
                                                                    'class' => 'required',
                                                                ],
                                                            ],
                                                        ]" />

                                                        <button type="button" class="generate-random btn btn-soft-main">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                height="20" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-wand">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M6 21l15 -15l-3 -3l-15 15l3 3" />
                                                                <path d="M15 6l3 3" />
                                                                <path
                                                                    d="M9 3a2 2 0 0 0 2 2a2 2 0 0 0 -2 2a2 2 0 0 0 -2 -2a2 2 0 0 0 2 -2" />
                                                                <path
                                                                    d="M19 13a2 2 0 0 0 2 2a2 2 0 0 0 -2 2a2 2 0 0 0 -2 -2a2 2 0 0 0 2 -2" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="buttons-update">
                                                    <button type="submit"
                                                        class="btn btn-main">{{ dbTrans('admin.Change Password') }}</button>
                                                </div><!-- Button Update -->

                                            </form><!-- from -->
                                        @else
                                            <form class="ajax-post" action="{{ route('change-profile-password') }}"
                                                method="post">

                                                @csrf
                                                @method('PATCH')

                                                <!-- Start Input ID -->
                                                <x-form-group class="my-0" :properties="$inputId" />
                                                <!-- End Input ID -->


                                                <div class="row">

                                                    <div class="col-md-4">
                                                        <x-form-group class="mb-1" :properties="[
                                                            'input' => [
                                                                'name' => 'old_password',
                                                                'options' => ['required'],
                                                            ],
                                                            'label' => [
                                                                'text' => dbTrans('admin.Old Password'),
                                                                'options' => [
                                                                    'class' => 'required',
                                                                ],
                                                            ],
                                                        ]" />

                                                        <button type="button"
                                                            data-id="{{ Crypt::encryptString($row->id) }}"
                                                            id="btn-forgot-password"
                                                            class="mb-3 text-secondary font-13 text-decoration-underline">
                                                            {{ dbTrans('admin.Forget Password') }}
                                                        </button>
                                                    </div><!-- old_password -->

                                                    <div class="col-md-4">
                                                        <x-form-group :properties="[
                                                            'input' => [
                                                                'name' => 'password',
                                                                'options' => ['required'],
                                                            ],
                                                            'label' => [
                                                                'text' => dbTrans('admin.New Password'),
                                                                'options' => [
                                                                    'class' => 'required',
                                                                ],
                                                            ],
                                                        ]" />
                                                    </div><!-- new_password -->


                                                    <div class="col-md-4">
                                                        <x-form-group :properties="[
                                                            'input' => [
                                                                'name' => 'password_confirmation',
                                                                'options' => ['required'],
                                                            ],
                                                            'label' => [
                                                                'text' => dbTrans('admin.Confirm Password'),
                                                                'options' => [
                                                                    'class' => 'required',
                                                                ],
                                                            ],
                                                        ]" />
                                                    </div><!-- password_confirmation -->


                                                </div><!-- row -->

                                                <div class="buttons-update">
                                                    <button type="submit"
                                                        class="btn btn-main">{{ dbTrans('admin.Change Password') }}</button>
                                                </div><!-- Button Update -->

                                            </form><!-- from -->
                                        @endif
                                    </div><!-- Change Password -->

                                    <div class="tab-pane fa_de" id="experience" role="tabpanel"
                                        aria-labelledby="experience-tab">
                                        <form class=" ajax-post" action="{{ route('experience') }}" method="post">
                                            @csrf
                                            <!-- Start Input ID -->
                                            <x-form-group class="my-0" :properties="$inputId" />
                                            <!-- End Input ID -->

                                            <section id="form-inputs">

                                                <div
                                                    class="@if (count($experiences) > 0) {{ 'display-none' }} @endif text-center exp-empty-box">
                                                    <img class="w256"
                                                        src="{{ asset('dashboard/images/empty-box.png') }}"
                                                        alt="empty" title="Empty">
                                                </div>

                                                @foreach ($experiences as $exp)
                                                    <div class="row experience-card">

                                                        <x-form-group :properties="[
                                                            'input' => [
                                                                'type' => 'hidden',
                                                                'name' => 'exp_id[]',
                                                                'value' => $exp->id,
                                                            ],
                                                        ]" /><!-- exp_id -->

                                                        <div class="col-md-12">
                                                            <x-form-group :properties="[
                                                                'input' => [
                                                                    'name' => 'job_title[]',
                                                                    'value' => $exp->job_title,
                                                                ],
                                                                'label' => [
                                                                    'text' => dbTrans('admin.Job Title'),
                                                                    'options' => [
                                                                        'class' => 'required',
                                                                    ],
                                                                ],
                                                            ]" />
                                                        </div><!-- job_title -->

                                                        <div class="col-md-6">
                                                            <x-form-group :properties="[
                                                                'input' => [
                                                                    'name' => 'company_name[]',
                                                                    'value' => $exp->company_name,
                                                                    'options' => ['required'],
                                                                ],
                                                                'label' => [
                                                                    'text' => dbTrans('admin.Company Name'),
                                                                    'options' => [
                                                                        'class' => 'required',
                                                                    ],
                                                                ],
                                                            ]" />
                                                        </div><!-- company_name -->

                                                        <div class="col-md-3 parents-col-for-start-year">
                                                            <x-form-group :properties="[
                                                                'select' => [
                                                                    'name' => 'start_year[]',
                                                                    'selected' => $exp->start_year,
                                                                    'list' => $years,
                                                                    'options' => [
                                                                        'required',
                                                                        'class' => 'start-year set-years',
                                                                    ],
                                                                ],
                                                                'label' => [
                                                                    'text' => dbTrans('admin.Start Year'),
                                                                    'options' => [
                                                                        'class' => 'required',
                                                                    ],
                                                                ],
                                                            ]" />
                                                        </div><!-- start_year -->

                                                        <div class="col-md-3 parents-col-for-end-year">
                                                            <x-form-group :properties="[
                                                                'select' => [
                                                                    'name' => 'end_year[]',
                                                                    'selected' => $exp->end_year,
                                                                    'list' => $years,
                                                                    'options' => ['required', 'class' => 'end-years'],
                                                                ],
                                                                'label' => [
                                                                    'text' => dbTrans('admin.End Year'),
                                                                    'options' => [
                                                                        'class' => 'required',
                                                                    ],
                                                                ],
                                                            ]" />
                                                        </div><!-- end_year -->

                                                        <div class="col-md-12">
                                                            <x-form-group :properties="[
                                                                'textarea' => [
                                                                    'name' => 'job_desc[]',
                                                                    'value' => $exp->job_desc,
                                                                    'options' => ['required', 'rows' => 3],
                                                                ],
                                                                'label' => [
                                                                    'text' => dbTrans('admin.Job Description'),
                                                                    'options' => [
                                                                        'class' => 'required',
                                                                    ],
                                                                ],
                                                            ]" />
                                                        </div><!-- job_desc -->

                                                        <div class="btn-delete-job btn btn-soft-danger font-15 tip"
                                                            title="Delete"
                                                            data-admin-id="{{ Crypt::encryptString($row->id) }}"
                                                            data-id="{{ $exp->id }}">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </div>
                                                        <!-- Delete Job -->

                                                    </div><!-- row -->
                                                @endforeach

                                            </section> <!-- form inputs -->

                                            <div class="buttons-update">
                                                <button type="submit" class="btn btn-main">Save</button>
                                                <!-- Button Update -->
                                                <button id="btn-exp-add-new" type="button"
                                                    class="btn btn-soft-main">{{ dbTrans('admin.Add New') }}</button>
                                                <!-- Button Add New -->
                                            </div>
                                        </form><!-- from -->
                                    </div><!-- experience -->

                                    @if ($row->id == adminId())
                                        <div class="tab-pane fa_de " id="account" role="tabpanel"
                                            aria-labelledby="account-tab">

                                            <div id="security" class="mb-5">
                                                <div class="info">
                                                    <h6 class=" font-weight-600 text-decoration-underline">
                                                        {{ dbTrans('admin.Security') }}:</h6>
                                                    <p class=" text-second mb-0 font-14">
                                                        {{ dbTrans('admin.Two-factor Authentication') }}</p>
                                                </div>
                                                <form action="" method="POST">
                                                    <button type="submit"
                                                        class="btn btn-sm btn-success">{{ dbTrans('admin.Enable') }}</button>
                                                </form>
                                                <div class="clearfix"></div>
                                            </div><!-- security -->


                                            <div id="delete-account">
                                                <div class="mb-3">
                                                    <h6 class=" font-weight-600 text-decoration-underline mb-2">
                                                        {{ dbTrans('admin.Delete This Account') }}:</h6>
                                                    <p class=" text-second mb-0 font-14">
                                                        {{ dbTrans('admin.Deleting your account completely from the site, this will delete your data as well') }}
                                                    </p>
                                                </div>
                                                <form action="" method="POST">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <x-form-group :properties="[
                                                                'input' => [
                                                                    'name' => 'password',
                                                                    'options' => [
                                                                        'required',
                                                                        'placeholder' => 'Password',
                                                                    ],
                                                                ],
                                                            ]" />
                                                        </div>
                                                    </div>
                                                    <button type="submit"
                                                        class="btn btn-sm btn-soft-danger my-1">{{ dbTrans('admin.Close & Delete This Account') }}</button>

                                                    <button type="reset"
                                                        class="btn btn-sm btn-soft-main my-1">{{ dbTrans('admin.Cancel') }}</button>
                                                </form>
                                                <div class="clearfix"></div>
                                            </div><!-- security -->


                                        </div><!-- account -->
                                    @endif <!-- Account -->

                                    @if (canRole(owner()) && $row->id != adminId())

                                        <div class="tab-pane
                                                    fa_de "
                                            id="roles" role="tabpanel" aria-labelledby="roles-tab">

                                            @if ($row->type == 'sales')
                                                <div class="alert alert-info" role="alert">
                                                    هذا الحساب من نوع <strong>مسؤول مبيعات</strong> ولا يمكن اضافة ادوار
                                                    اخري
                                                </div>
                                            @else
                                                <form class="ajax-post" action="{{ route('change-roles') }}"
                                                    method="post">

                                                    <!-- Start Input ID -->
                                                    <x-form-group class="my-0" :properties="$inputId" />
                                                    <!-- End Input ID -->

                                                    @csrf
                                                    @method('PATCH')

                                                    <div class="row">
                                                        @foreach ($roles as $role)
                                                            <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                                                                <x-form-group class="mb-1 ltr" :properties="[
                                                                    'input' => [
                                                                        'name' => 'roles[]',
                                                                        'type' => 'checkbox',
                                                                        'value' => $role,
                                                                        'options' => [
                                                                            'class' => 'd-inline-block',
                                                                            'id' => 'role-' . $role,
                                                                            isset($hasRoles[$role]) ? 'checked' : null,
                                                                        ],
                                                                    ],
                                                                    'label' => [
                                                                        'text' => Str::headline($role),
                                                                        'options' => [
                                                                            'class' =>
                                                                                'd-inline-block cursor-pointer font-16',
                                                                            'for' => 'role-' . $role,
                                                                        ],
                                                                    ],
                                                                ]" />
                                                            </div>
                                                        @endforeach
                                                    </div>


                                                    <div class="buttons-update">
                                                        <button type="submit"
                                                            class="btn btn-main">{{ dbTrans('admin.Save') }}</button>
                                                    </div><!-- Button Update -->

                                                </form><!-- from -->
                                            @endif

                                        </div><!-- Roles -->

                                        <div class="tab-pane fa_de" id="actions" role="tabpanel"
                                            aria-labelledby="actions-tab">
                                            <form class="delete" action="{{ route('delete-admin') }}" method="POST">

                                                <!-- Start Input ID -->
                                                <x-form-group class="my-0" :properties="$inputId" />
                                                <!-- End Input ID -->

                                                @csrf
                                                @method('DELETE')

                                                <div id="delete-account">
                                                    <div class="mb-3">
                                                        <h6 class=" font-weight-600 text-decoration-underline mb-2">
                                                            {{ dbTrans('admin.Delete This Account') }} :</h6>
                                                        <p class=" text-second mb-0 font-14">
                                                            {{ dbTrans('admin.Deleting your account completely from the site, this will delete your data as well') }}
                                                        </p>
                                                    </div>


                                                    <button type="submit"
                                                        data-delete="Are you sure to permanently delete ' {{ $row->f_name }} ' account ?"
                                                        class="btn btn-sm btn-soft-danger my-1">
                                                        {{ dbTrans('admin.Close & Delete This Account') }} </button>

                                                    <div class="clearfix"></div>
                                                </div><!-- security -->


                                            </form><!-- from -->
                                        </div><!-- Actions -->

                                    @endif <!-- Roles + Actions-->

                                </div>
                            </div><!-- box body -->


                        </div>
                    </section>
                </div><!-- Grid 2 -->


            </div>
        </div>


    </main><!-- end main -->

@endsection

<x-dashboard.js :links="[
    [
        'link' => 'admin/profile/edit',
        'type' => 'module',
    ],
    [
        'link' => 'image-preview',
        'from' => 'components',
    ],

    [
        'link' => 'generate-random-characters',
        'from' => 'components',
    ],
]" />
