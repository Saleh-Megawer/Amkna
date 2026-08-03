@extends('dashboard.layouts.master')
@section('title', '1')
@section('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/pages/clients/show.css') }}">
@endsection
@section('content')

    <x-dashboard.links-bar :links="[
        [
            'name' => $linksMap['index']['title'],
            'link' => $linksMap['index']['url'],
        ],
        [
            'name' => $client->name,
        ],
    ]" /><!-- links bar -->


    <div class="box mb-3 client-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">

            {{-- Client Info --}}
            <div class="d-flex align-items-center">


                <div class="ml-3">
                    @if ($client->avatar)
                        <img src="{{ asset('storage/' . $client->avatar) }}" alt="{{ $client->name }}"
                            class="client-avatar rounded-circle">
                    @else
                        <div
                            class="client-avatar-placeholder rounded-circle bg-primary text-white d-flex align-items-center justify-content-center">
                            {{ mb_substr($client->name, 0, 1) }}
                        </div>
                    @endif
                </div> {{-- Avatar --}}


                <div>
                    <h4 class="mb-2">{{ $client->name }}</h4>

                    <div class="d-flex align-items-center flex-wrap">
                        {{-- Status Badge --}}
                        @if ($client->status == 1)
                            <span class="badge badge-md badge-success ml-1 mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5 12l5 5l10 -10" />
                                </svg>
                                حساب مفعّل
                            </span>
                        @else
                            <span class="badge badge-md badge-danger ml-1 mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-ban">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                    <path d="M5.7 5.7l12.6 12.6" />
                                </svg>
                                حساب محظور
                            </span>
                        @endif

                        {{-- Has Account Badge --}}
                        @if ($client->has_account)
                            <span class="badge badge-md badge-info ml-2 mb-1">لدية حساب</span>
                        @endif

                        {{-- Registered Date --}}
                        <small class="text-muted mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-week">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12" />
                                <path d="M16 3v4" />
                                <path d="M8 3v4" />
                                <path d="M4 11h16" />
                                <path d="M7 14h.013" />
                                <path d="M10.01 14h.005" />
                                <path d="M13.01 14h.005" />
                                <path d="M16.015 14h.005" />
                                <path d="M13.015 17h.005" />
                                <path d="M7.01 17h.005" />
                                <path d="M10.01 17h.005" />
                            </svg>
                            انضم: <bdo dir="ltr">{{ $client->created_at->format('Y-m-d') }}</bdo>
                        </small>
                    </div>
                </div>{{-- Name & Status --}}


            </div><!-- end flex -->


            <div class="d-flex mt-3 mt-md-0">

                <a href="{{ route('crm.clients.index') }}" class="btn btn-soft-main ml-1">
                    <div class=" d-flex align-items-center">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l14 0" />
                                <path d="M13 18l6 -6" />
                                <path d="M13 6l6 6" />
                            </svg>
                        </span><!-- end icon -->
                        <span>رجوع</span>
                    </div>
                </a>


                <button type="button" class="btn btn-second dropdown-toggle" data-toggle="dropdown">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-dots-vertical">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M11 12a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                            <path d="M11 19a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                            <path d="M11 5a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                        </svg>
                    </span>
                    <span>إجراءات</span>
                </button>

                <div class="dropdown-menu dropdown-basic text-right">

                    <form class="form-status d-inline-block dropdown-item form-status ajax-post"
                        action="{{ route('crm.clients.change-status') }}" method="post">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="id" value="{{ $client->uuid }}">

                        @include('dashboard.crm.clients.partials.status-button', [
                            'client' => $client,
                        ])
                    </form>


                    <div class="dropdown-divider"></div>

                    <form class="dropdown-item ajax-delete d-inline-block"
                        action="{{ route('crm.clients.destroy', $client) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        {{-- <input type="hidden" class="id" name="id"
                                            value="{{ $client->uuid }}"> --}}
                        <button style="color: #ff0000" type="submit"
                            data-delete="هل انت متأكد من حذف : {{ $client->name }}" class="p-0 font-16 bg-transparent">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 7l16 0" />
                                <path d="M10 11l0 6" />
                                <path d="M14 11l0 6" />
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                            </svg>
                            حذف
                        </button>
                    </form><!-- end delete client -->




                </div><!-- actions -->



            </div>{{-- Actions --}}

        </div>
    </div>


    {{-- Statistics Cards --}}
    <div class="row">
        <div class="col-lg-3 col-sm-6 my-2">
            <div class="box stats-card">
                <div class="stats-icon bg-primary-light rounded-circle d-flex align-items-center justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 21l18 0" />
                        <path d="M9 8l1 0" />
                        <path d="M9 12l1 0" />
                        <path d="M9 16l1 0" />
                        <path d="M14 8l1 0" />
                        <path d="M14 12l1 0" />
                        <path d="M14 16l1 0" />
                        <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16" />
                    </svg>
                </div>
                <h3 class="stats-value mb-1">{{ $stats['total_deals'] }}</h3>
                <p class="stats-label text-muted mb-0">إجمالي الصفقات</p>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 my-2">
            <div class="box stats-card">
                <div class="stats-icon bg-success-light rounded-circle d-flex align-items-center justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                        <path d="M9 12l2 2l4 -4" />
                    </svg>
                </div>
                <h3 class="stats-value mb-1">{{ $stats['won_deals'] }}</h3>
                <p class="stats-label text-muted mb-0">صفقات ناجحة</p>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 my-2">
            <div class="box stats-card">
                <div class="stats-icon bg-info-light rounded-circle d-flex align-items-center justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
                    </svg>
                </div>
                <h3 class="stats-value mb-1">{{ $stats['total_interests'] }}</h3>
                <p class="stats-label text-muted mb-0">الاهتمامات</p>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 my-2">
            <div class="box stats-card">
                <div class="stats-icon bg-warning-light rounded-circle d-flex align-items-center justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                    </svg>
                </div>
                <h3 class="stats-value mb-1">{{ $stats['unread_interests'] }}</h3>
                <p class="stats-label text-muted mb-0">اهتمامات جديدة</p>
            </div>
        </div>
    </div>

    {{-- Personal Information --}}
    <div class="row">
        <div class="col-lg-6 mb-3 mb-lg-2">
            <div class="box">
                <div class="box-title px-0">معلومات شخصية</div>
                <div class="box-body px-0 pb-0">

                    {{-- Name --}}
                    <div class="info-row d-flex justify-content-between align-items-center">
                        <div class="info-label d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="ml-2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            </svg>
                            الاسم
                        </div>
                        <div class="info-value">{{ $client->name }}</div>
                    </div>

                    {{-- Email --}}
                    <div class="info-row d-flex justify-content-between align-items-center">
                        <div class="info-label d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="ml-2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                <path d="M3 7l9 6l9 -6" />
                            </svg>
                            البريد الإلكتروني
                        </div>
                        <div class="info-value">
                            @if ($client->email)
                                @if ($client->email_verified_at)
                                    <span class="badge badge-md badge-success badge-sm">موثق</span>
                                @endif
                                {{ $client->email }}
                            @else
                                <span class="text-muted">غير متوفر</span>
                            @endif
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div class="info-row d-flex justify-content-between align-items-center">
                        <div class="info-label d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="ml-2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                            </svg>
                            رقم الجوال
                        </div>
                        <div class="info-value" dir="ltr">
                            {{ $client->phone ?: 'غير متوفر' }}
                        </div>
                    </div>

                    {{-- Phone Alt --}}
                    @if ($client->phone_alt)
                        <div class="info-row d-flex justify-content-between align-items-center">
                            <div class="info-label d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="ml-2">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                                </svg>
                                جوال بديل
                            </div>
                            <div class="info-value" dir="ltr">{{ $client->phone_alt }}</div>
                        </div>
                    @endif

                    {{-- City --}}
                    <div class="info-row d-flex justify-content-between align-items-center">
                        <div class="info-label d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="ml-2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" />
                            </svg>
                            المدينة
                        </div>
                        <div class="info-value">{{ $client->city?->name ?: 'غير محدد' }}</div>
                    </div>

                    {{-- Neighborhood --}}
                    @if ($client->neighborhood)
                        <div class="info-row d-flex justify-content-between align-items-center">
                            <div class="info-label d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="ml-2">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M12 20l-3 -3h-2a3 3 0 0 1 -3 -3v-6a3 3 0 0 1 3 -3h10a3 3 0 0 1 3 3v6a3 3 0 0 1 -3 3h-2l-3 3" />
                                    <path d="M8 9l8 0" />
                                    <path d="M8 13l6 0" />
                                </svg>
                                الحي
                            </div>
                            <div class="info-value">{{ $client->neighborhood->name }}</div>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-3 mb-lg-2">
            <div class="box">
                <div class="box-title px-0">معلومات إضافية</div>
                <div class="box-body px-0 pb-0">

                    {{-- Source --}}
                    <div class="info-row d-flex justify-content-between align-items-center">
                        <div class="info-label d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="ml-2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                <path d="M12 7v5l3 3" />
                            </svg>
                            المصدر
                        </div>
                        <div class="info-value">{{ $client->source_display ?: 'غير محدد' }}</div>
                    </div>

                    {{-- Assigned To --}}
                    <div class="info-row d-flex justify-content-between align-items-center">
                        <div class="info-label d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="ml-2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                            </svg>
                            المكلف
                        </div>
                        <div class="info-value">{{ $client->assignedAdmin?->full_name ?: 'غير مكلف' }}</div>
                    </div>

                    {{-- Created By --}}
                    <div class="info-row d-flex justify-content-between align-items-center">
                        <div class="info-label d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="ml-2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            </svg>
                            أنشأ بواسطة
                        </div>
                        <div class="info-value">{{ $client->creator?->full_name ?: 'غير محدد' }}</div>
                    </div>

                    {{-- Created At --}}
                    <div class="info-row d-flex justify-content-between align-items-center">
                        <div class="info-label d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="ml-2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                <path d="M16 3v4" />
                                <path d="M8 3v4" />
                                <path d="M4 11h16" />
                            </svg>
                            تاريخ التسجيل
                        </div>
                        <div class="info-value">{{ $client->created_at->format('Y-m-d h:i A') }}</div>
                    </div>

                    {{-- Last Seen --}}
                    @if ($client->last_seen)
                        <div class="info-row d-flex justify-content-between align-items-center">
                            <div class="info-label d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="ml-2">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                </svg>
                                آخر ظهور
                            </div>
                            <div class="info-value">{{ $client->last_seen->diffForHumans() }}</div>
                        </div>
                    @endif

                    {{-- Tags --}}
                    @if ($client->tags->count() > 0)
                        <div class="info-row d-flex justify-content-between align-items-start">
                            <div class="info-label d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="ml-2">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M7.859 6h-2.834a2.025 2.025 0 0 0 -2.025 2.025v2.834c0 .537 .213 1.052 .593 1.432l6.116 6.116a2.025 2.025 0 0 0 2.864 0l2.834 -2.834a2.025 2.025 0 0 0 0 -2.864l-6.117 -6.116a2.025 2.025 0 0 0 -1.431 -.593z" />
                                    <path d="M17.573 18.407l2.834 -2.834a2.025 2.025 0 0 0 0 -2.864l-7.117 -7.116" />
                                    <path d="M6 9h-.01" />
                                </svg>
                                الوسوم
                            </div>
                            <div class="info-value">
                                @foreach ($client->tags as $tag)
                                    <span class="badge badge-md badge-secondary">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>


    {{-- Deals Section --}}
    <div class="row">
        <div class="col-12 mb-2">
            <div class="box form-box table-responsive">
                <div class="box-title d-flex justify-content-between align-items-center px-3 pt-3">
                    <span>الصفقات ({{ $client->deals->count() }})</span>
                </div>

                <table class="table table-modern text-center table-modern-sm table-inverse">
                    <thead class="thead-inverse">
                        <tr>
                            <th>#</th>
                            <th>نوع العقار</th>
                            <th>الغرض</th>
                            <th>الميزانية</th>
                            <th>المكلف</th>
                            <th>الحالة</th>
                            <th>الأوسمة</th>
                            <th>العمولة</th>
                            <th>الملاحظات</th>
                            <th>التاريخ</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($client->deals as $row)
                            <tr class="parents">
                                {{-- # --}}
                                <td>{{ $row->id }}</td>

                                {{-- Property Type --}}
                                <td>
                                    <a class=" font-weight-500" href="{{ route('crm.deals.edit', $row->uuid) }}">
                                        {{ $row->propertyType?->name ?? '-' }}
                                    </a>
                                </td>

                                {{-- Purpose - استخدام Enum --}}
                                <td>
                                    {!! $row->purpose->icon() !!}
                                    {{ $row->purpose->label() }}
                                </td>

                                {{-- Budget --}}
                                <td>
                                    @if ($row->budget_min && $row->budget_max)
                                        <span class="text-nowrap">{{ number_format($row->budget_min) }} -
                                            {{ number_format($row->budget_max) }}</span>
                                    @elseif($row->amount)
                                        <span class="text-nowrap">{{ number_format($row->amount) }}</span>
                                    @else
                                        -
                                    @endif
                                </td>

                                {{-- Assigned To --}}
                                <td>{{ $row->assignedTo?->full_name ?? '-' }}</td>

                                {{-- Status --}}
                                <td>
                                    @if ($row->is_won)
                                        <span class="badge badge-md badge-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M5 12l5 5l10 -10" />
                                            </svg>
                                            ناجحة
                                        </span>
                                    @elseif($row->is_lost)
                                        <span class="badge badge-md badge-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M18 6l-12 12" />
                                                <path d="M6 6l12 12" />
                                            </svg>
                                            فاشلة
                                        </span>
                                    @else
                                        <span class="badge badge-md badge-main">
                                            قيد المعالجة
                                        </span>
                                    @endif
                                </td>

                                {{-- Tags --}}
                                <td>
                                    @if ($row->tags->count())
                                        @foreach ($row->tags as $tag)
                                            <span style="background-color: {{ $tag->color }};color:#fff;"
                                                class="badge badge-md mx-1">
                                                {{ $tag->name }}
                                            </span>
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </td>

                                {{-- Commission --}}
                                <td>
                                    @if ($row->commission)
                                        {{ number_format($row->commission) }}
                                    @else
                                        -
                                    @endif
                                </td>

                                {{-- Notes --}}
                                <td class="text-start"
                                    style="max-width:200px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                    {{ $row->notes ?: '-' }}
                                </td>

                                {{-- Created At --}}
                                <td class="ltr">{{ $row->created_at->format('Y-m-d • H:i') }}</td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="11" class="text-center pt-4 text-muted">لا توجد صفقات لهذا العميل</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    {{-- Interests Section --}}
    <div class="row">
        <div class="col-12 mb-3">
            <div class="box form-box table-responsive">
                <div class="box-title d-flex justify-content-between align-items-center px-3 pt-3">
                    <span>الاهتمامات ({{ $client->interests->count() }})</span>
                    @if ($stats['unread_interests'] > 0)
                        <span class="badge badge-md badge-warning">{{ $stats['unread_interests'] }} جديدة</span>
                    @endif
                </div>

                <table class="table table-modern text-center table-modern-sm table-inverse">
                    <thead class="thead-inverse">
                        <tr>
                            <th>#</th>
                            <th>العقار</th>
                            <th>الرسالة</th>
                            <th>المكلف</th>
                            <th>الحالة</th>
                            <th>القراءة</th>
                            <th>التاريخ</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($client->interests as $row)
                            <tr class="parents">
                                {{-- # --}}
                                <td>{{ $row->id }}</td>

                                {{-- Property --}}
                                <td>
                                    @if ($row->property)
                                        <a href="" class="text-primary" target="_blank" title="عرض العقار">
                                            {{ Str::limit($row->property->title ?? 'عقار #' . $row->property->id, 30) }}
                                        </a>
                                    @else
                                        <span class="text-muted">غير مرتبط بعقار</span>
                                    @endif
                                </td>


                                {{-- Message --}}
                                <td class="text-start"
                                    style="max-width:250px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                    {{ $row->message ?: '-' }}
                                </td>

                                {{-- Assigned To --}}
                                <td>
                                    {!! $row->assignedTo?->full_name ?? '<span class="text-danger">لم يتم التعيين</span>' !!}
                                </td>

                                {{-- Status - استخدام Enum --}}
                                <td>
                                    <span class="badge badge-md {{ $row->status->badgeClass() }}">
                                        {!! $row->status->icon() !!}
                                        {{ $row->status->label() }}
                                    </span>
                                </td>

                                {{-- Is Read --}}
                                <td>
                                    @if ($row->is_read)
                                        <span class="badge badge-md badge-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M9 11l3 3l8 -8" />
                                                <path
                                                    d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" />
                                            </svg>
                                            مقروء
                                        </span>
                                    @else
                                        <span class="badge badge-md badge-warning">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                                <path d="M3 7l9 6l9 -6" />
                                            </svg>
                                            جديد
                                        </span>
                                    @endif
                                </td>

                                {{-- Created At --}}
                                <td class="ltr">{{ $row->created_at->format('Y-m-d • H:i') }}</td>


                            </tr>

                        @empty
                            <tr>
                                <td colspan="9" class="text-center pt-4 text-muted">لا توجد اهتمامات لهذا العميل</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>




@endsection
@section('js')

@endsection
