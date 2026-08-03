@extends('dashboard.layouts.master')
@section('title', $ownerAssociation->name . ' - ' . $linksMap['index']['title'])
@section('meta')
    <meta name="owner-association-uuid" content="{{ $ownerAssociation->uuid }}">
@endsection
<x-dashboard.css :links="[
    [
        'link' => 'owner-associations/index.css',
    ],
]" />
@section('content')

    <x-dashboard.links-bar :links="[
        [
            'name' => $linksMap['index']['title'],
            'link' => $linksMap['index']['url'],
        ],
        [
            'name' => Str::limit($ownerAssociation->name, 20),
        ],
    ]" /><!-- links bar -->


    <div class="row">

        <div class="col-xl-3">

            <section id="analytics">

                <div class="box mb-3">

                    <h6 class="mb-1 text-muted font-18">عدد الوحدات</h6>
                    <h4 class="mb-0 font-weight-700">{{ $ownerAssociation->units->count() }}</h4>

                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-buildings">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 21v-15c0 -1 1 -2 2 -2h5c1 0 2 1 2 2v15" />
                            <path d="M16 8h2c1 0 2 1 2 2v11" />
                            <path d="M3 21h18" />
                            <path d="M10 12v0" />
                            <path d="M10 16v0" />
                            <path d="M10 8v0" />
                            <path d="M7 12v0" />
                            <path d="M7 16v0" />
                            <path d="M7 8v0" />
                            <path d="M17 12v0" />
                            <path d="M17 16v0" />
                        </svg>
                    </div>

                </div><!-- untis count -->

                <div class="box mb-3">

                    <h6 class="mb-1 text-muted font-18">عدد الملاك</h6>
                    <h4 class="mb-0 font-weight-700">
                        {{ $numberOfOwners }}</h4>

                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                        </svg>
                    </div>

                </div><!-- client_id count -->

                <div class="box mb-3">

                    <a href="{{ route('owner-associations.requests.index', $ownerAssociation) }}">
                        <h6 class="mb-1 font-18">عدد الطلبات & الشكاوي</h6>
                        <h4 class="mb-0 font-weight-700">{{ $requestsCount }}</h4>
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-alert-circle">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                <path d="M12 8v4" />
                                <path d="M12 16h.01" />
                            </svg>
                        </div>
                    </a>
                </div><!-- complaintsCount -->

            </section><!-- analytics -->

        </div><!-- grid 1 -->

        <div class="col-xl-9">

            <section class="owner-associations-info">
                <div class="box">

                    <div class="d-flex justify-content-between align-items-center">

                        <h5 class="mb-0 font-weight-600">{{ $ownerAssociation->name }}</h5>

                        <div class="">

                            <button data-toggle="modal" data-target="#model-edit-owner-association"
                                class="btn btn-outline-primary btn-action-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                    <path d="M16 5l3 3" />
                                </svg>
                            </button><!-- btn edit owner-association -->


                            <form class="delete d-inline-block"
                                action="{{ route('owner-associations.destroy', $ownerAssociation->uuid) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button title="حذف نهائي" type="submit"
                                    data-delete="هل انت متأكد من حذف : {{ $ownerAssociation->name }}"
                                    class="btn-delete-attech btn-action-icon tip btn btn-outline-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
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
                                </button>
                            </form><!-- delete -->

                        </div>

                    </div><!-- btn-edit + ownerAssociation name -->

                    <p class="oa-notes mt-2 text-secondary">
                        <span class="notes-short">
                            {!! nl2br(e(Str::limit($ownerAssociation->notes, 300, ''))) !!}
                        </span>

                        @if (strlen($ownerAssociation->notes) > 300)
                            <span class="notes-more d-none">
                                {!! nl2br(e(Str::substr($ownerAssociation->notes, 300))) !!}
                            </span>

                            <a href="javascript:void(0)" class="notes-toggle" data-state="collapsed">
                                قراءة المزيد
                            </a>
                        @endif
                    </p><!-- notes -->

                    @if ($ownerAssociation->manager)
                        <div class="mt-2">

                            <span class=" font-weight-500 icon font-18">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#000000"
                                    viewBox="0 0 256 256">
                                    <path
                                        d="M168.49,199.51a12,12,0,0,1-17,17l-80-80a12,12,0,0,1,0-17l80-80a12,12,0,0,1,17,17L97,128Z">
                                    </path>
                                </svg>
                                بيانات المسؤول
                            </span><!-- title -->

                            <div class="form-row mt-2">

                                <div class="col-sm-4 mb-3 mb-sm-0">
                                    <div class="border radius text-center py-3 icon">

                                        {{ $ownerAssociation->manager->name }}

                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                            <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                            <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                                        </svg>

                                    </div>
                                </div><!--  -->

                                <div class="col-sm-4 mb-3 mb-sm-0">
                                    <div class="border radius text-center py-3 ltr icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-phone">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                                        </svg>
                                        {{ $ownerAssociation->manager->country_code }}
                                        {{ $ownerAssociation->manager->phone }}
                                    </div>
                                </div><!--  -->

                                <div class="col-sm-4 mb-3 mb-sm-0">
                                    <div class="border radius text-center py-3 ltr icon">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-mail">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                            <path d="M3 7l9 6l9 -6" />
                                        </svg>
                                        {{ $ownerAssociation->manager->email }}
                                    </div>
                                </div><!--  -->

                            </div>

                        </div><!-- manager -->
                    @else
                        <div class="alert alert-warning text-center mb-0" role="alert">
                            <strong>لم يتم تعيين مسؤول</strong>
                        </div>
                    @endif

                </div>
            </section><!--  -->

            <section id="units">
                <div class="box">

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0 font-weight-600">الوحدات</h5>
                        <button class="btn btn-sm btn-soft-main" data-toggle="modal"
                            data-target="#model-add-unit-owner-association">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            إضافة وحدة
                        </button>
                    </div>

                    <div class="form-row">
                        @foreach ($ownerAssociation->units as $unit)
                            <div class="parents col-lg-4 col-md-6 my-2">
                                <div class="unit-card p-3">

                                    <!-- Header -->
                                    <div class="unit-card-header">
                                        <h6 class="unit-card-number">
                                            وحدة رقم {{ $unit->unit_number }}
                                        </h6>

                                        <div class="unit-card-actions">

                                            <button type="button"
                                                class="btn-edit-unit-owner-association btn btn-outline-primary btn-action-icon"
                                                data-unit-id="{{ $unit->id }}" title="تعديل">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                    <path
                                                        d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                    <path d="M16 5l3 3" />
                                                </svg>
                                            </button>

                                            <form class="ajax-delete d-inline-block"
                                                action="{{ route('owner-associations.units.destroy', [$ownerAssociation->uuid, $unit->id]) }}"
                                                method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit"
                                                    data-delete="هل انت متأكد من حذف وحدة رقم {{ $unit->unit_number }}؟"
                                                    class="btn-delete-attech btn btn-sm btn-outline-danger btn-action-icon"
                                                    title="حذف">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
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

                                        </div>

                                    </div>

                                    <!-- Body -->
                                    <div class="unit-card-body">
                                        <div class="unit-card-info">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                <path d="M12 9h.01" />
                                                <path d="M11 12h1v4h1" />
                                            </svg>
                                            <span>
                                                {{ $unit->propertyType->name }}
                                                @if ($unit->floor)
                                                    <span class="text-muted">— الدور {{ $unit->floor }}</span>
                                                @endif
                                            </span>
                                        </div>

                                        <div class="unit-card-info">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                                <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                                            </svg>
                                            <span>
                                                @if ($unit->client)
                                                    {{ $unit->client->name }}
                                                @else
                                                    <em class="text-muted">غير محدد</em>
                                                @endif
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Footer -->
                                    <div class="unit-card-footer">
                                        <small class="text-muted">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                <path d="M12 7v5" />
                                                <path d="M12 12h3.5" />
                                            </svg>
                                            أُضيفت {{ $unit->created_at->diffForHumans() }}
                                        </small>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section><!-- units -->

            <section id="polls" class="mb-5 pb-5">
                <div class="box">

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0 font-weight-600">الاستطلاعات</h5>
                        <button class="btn btn-sm btn-soft-main" data-toggle="modal" data-target="#model-add-poll">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            إضافة <span>استطلاع</span>
                        </button>
                    </div><!-- section title -->

                    <div class="form-row">
                        @forelse ($ownerAssociation->polls()->latest()->get() as $poll)
                            @php
                                $totalVotes = $poll->votes->count();
                                $yesVotes = $poll->votes->where('vote', 'yes')->count();
                                $noVotes = $poll->votes->where('vote', 'no')->count();
                                $yesPercentage = $totalVotes > 0 ? round(($yesVotes / $totalVotes) * 100, 1) : 0;
                                $noPercentage = $totalVotes > 0 ? round(($noVotes / $totalVotes) * 100, 1) : 0;
                            @endphp

                            <div class="col-12 mt-2">
                                <div class="parents poll-card">

                                    <div class="px-4 pt-4">

                                        {{-- Header --}}
                                        <div class="d-flex justify-content-between align-items-start mb-3">

                                            <div class="flex-grow-1">
                                                <h5 class="font-weight-600 mb-2">{{ $poll->title }}</h5>

                                                @if ($poll->description)
                                                    <p class="text-muted mb-2">{{ $poll->description }}</p>
                                                @endif

                                                <div class="d-flex align-items-center flex-wrap">
                                                    <small class="text-muted">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="15"
                                                            height="15" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-clock">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                            <path d="M12 7v5l3 3" />
                                                        </svg>
                                                        {{ $poll->created_at->diffForHumans() }}
                                                    </small>

                                                    <span
                                                        class="mx-2 font-10 pb-1 badge badge-{{ $poll->is_active ? 'success' : 'secondary' }}">
                                                        {{ $poll->is_active ? 'مفتوح' : 'مغلق' }}
                                                    </span>

                                                    <small class="text-muted">
                                                        (<svg xmlns="http://www.w3.org/2000/svg" width="15"
                                                            height="15" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                            <path d="M9 10a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                                            <path
                                                                d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                                                        </svg>
                                                        {{ $totalVotes }} تصويت
                                                        من
                                                        {{ $numberOfOwners }})
                                                    </small>
                                                </div>

                                            </div>

                                            <div class="poll-actions-actions">

                                                <button type="button"
                                                    class="btn-edit-poll btn btn-outline-primary btn-action-icon"
                                                    data-poll-id="{{ $poll->id }}" title="تعديل">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                        <path
                                                            d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                        <path d="M16 5l3 3" />
                                                    </svg>
                                                </button>

                                                <form class="ajax-delete d-inline-block"
                                                    action="{{ route('owner-associations.polls.destroy', [$ownerAssociation->uuid, $poll->id]) }}"
                                                    method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit"
                                                        data-delete="هل انت متأكد من حذف الاستطلاع : {{ Str::limit($poll->title, 50) }}"
                                                        class="btn-delete-attech btn btn-sm btn-outline-danger btn-action-icon"
                                                        title="حذف">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M4 7l16 0" />
                                                            <path d="M10 11l0 6" />
                                                            <path d="M14 11l0 6" />
                                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                        </svg>
                                                    </button>
                                                </form>

                                            </div><!-- poll-actions -->

                                        </div>

                                        {{-- Statistics --}}
                                        @if ($totalVotes > 0)
                                            <div class="row mb-3">
                                                <div class="col-md-6 mb-2">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <span class="text-success font-weight-600">
                                                            <i class="far fa-check-circle ml-1"></i>
                                                            نعم
                                                        </span>
                                                        <span class="font-weight-600">
                                                            {{ $yesVotes }}
                                                            <small class=" font-weight-500">صوت</small>
                                                            ({{ $yesPercentage }}%)
                                                        </span>
                                                    </div>
                                                    <div class="progress" style="height: 8px;">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            style="width: {{ $yesPercentage }}%"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-2">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <span class="text-danger font-weight-600">
                                                            <i class="far fa-times-circle ml-1"></i>
                                                            لا
                                                        </span>
                                                        <span class="font-weight-600">
                                                            {{ $noVotes }}
                                                            <small class=" font-weight-500">صوت</small>
                                                            ({{ $noPercentage }}%)
                                                        </span>
                                                    </div>
                                                    <div class="progress" style="height: 8px;">
                                                        <div class="progress-bar bg-danger" role="progressbar"
                                                            style="width: {{ $noPercentage }}%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    </div><!-- padding -->


                                    {{-- Votes List --}}
                                    @if ($totalVotes > 0)
                                        <hr>
                                        <div class="px-4 pb-4">

                                            <button class="btn-link mt-1 text-decoration-none collapsed" type="button"
                                                data-toggle="collapse" data-target="#votes-{{ $poll->id }}"
                                                aria-expanded="false" aria-controls="votes-{{ $poll->id }}">
                                                <span class="arrow-icon"
                                                    style="margin-right: -5px; transition: transform 0.3s ease;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M15 6l-6 6l6 6" />
                                                    </svg>
                                                </span>
                                                عرض التفاصيل ({{ $totalVotes }} تصويت)
                                            </button> {{-- btn show details --}}

                                            <div class="collapse mt-3" id="votes-{{ $poll->id }}">
                                                <div class="table-responsive">

                                                    <table
                                                        class="table table-sm table-bordered text-center table-inverse radius table-hover mb-0">
                                                        <thead class="thead-inverse bg-light">
                                                            <tr>
                                                                <th>العميل</th>
                                                                <th>الهاتف</th>
                                                                <th>التصويت</th>
                                                                <th>الملاحظات</th>
                                                                <th>التاريخ</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($poll->votes()->latest()->get() as $vote)
                                                                <tr>
                                                                    <td>
                                                                        <a href="{{ route('crm.clients.show', $vote->client) }}"
                                                                            target="_blank" rel="noopener noreferrer">
                                                                            {{ $vote->client->name }}
                                                                        </a>
                                                                    </td>

                                                                    <td class="ltr">
                                                                        {{ $vote->client->country_code != null ? '(' . $vote->client->country_code . ') ' : '' }}{{ $vote->client->phone }}
                                                                    </td>

                                                                    <td>
                                                                        @if ($vote->vote === 'yes')
                                                                            <span class="badge badge-soft-success">
                                                                                نعم
                                                                            </span>
                                                                        @else
                                                                            <span class="badge badge-soft-danger">
                                                                                لا
                                                                            </span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($vote->notes)
                                                                            <span class="show-full-text cursor-pointer"
                                                                                data-text="{{ $vote->notes }}">
                                                                                {!! Str::limit($vote->notes, 20, ' <span class="text-primary">المزيد...</span>') !!}
                                                                            </span>
                                                                        @else
                                                                            <span class="text-muted">-</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="ltr d-inline-block font-14">{{ $vote->created_at->format('Y-m-d h:i A') }}</span>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>{{-- Table --}}

                                        </div>
                                    @else
                                        <div class="text-center p-4 bg-light rounded">
                                            <i class="far fa-inbox text-muted mb-2" style="font-size: 2rem;"></i>
                                            <p class="text-muted mb-0 small">لا توجد أصوات حتى الآن</p>
                                        </div>
                                    @endif

                                </div><!-- poll-card -->
                            </div>

                            {{-- Modal: Vote Details --}}
                            @foreach ($poll->votes as $vote)
                                <div class="modal fade" id="modal-vote-details-{{ $vote->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">تفاصيل التصويت</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="text-muted small">العميل</label>
                                                    <div class="font-weight-600">{{ $vote->client->name }}</div>
                                                    <small class="text-muted">{{ $vote->client->phone }}</small>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="text-muted small">التصويت</label>
                                                    <div>
                                                        @if ($vote->vote === 'yes')
                                                            <span class="badge badge-success badge-lg">
                                                                <i class="far fa-check-circle ml-1"></i>
                                                                نعم
                                                            </span>
                                                        @else
                                                            <span class="badge badge-danger badge-lg">
                                                                <i class="far fa-times-circle ml-1"></i>
                                                                لا
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                @if ($vote->notes)
                                                    <div class="mb-3">
                                                        <label class="text-muted small">الملاحظات</label>
                                                        <div class="bg-light p-3 rounded">{{ $vote->notes }}</div>
                                                    </div>
                                                @endif

                                                <div class="mb-0">
                                                    <label class="text-muted small">تاريخ التصويت</label>
                                                    <div>{{ $vote->created_at->format('Y-m-d h:i A') }}</div>
                                                    <small
                                                        class="text-muted">{{ $vote->created_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        @empty
                            <div class="col-12">
                                <div class="text-center py-5 text-muted">
                                    <i class="far fa-clipboard-list mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                                    <p class="mb-0">لا توجد استطلاعات حتى الآن</p>
                                    <small>قم بإضافة أول استطلاع للبدء</small>
                                </div>
                            </div>
                        @endforelse
                    </div>

                </div>
            </section><!-- polls -->

        </div><!-- grid 2 -->

    </div><!-- parnet row -->












    <!-- Modal Add Owner Association -->
    <div class="modal fade " id="model-add-unit-owner-association" tabindex="-1" role="dialog"
        aria-labelledby="modelTitleId" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form class="form" action="{{ route('owner-associations.units.store', $ownerAssociation->uuid) }}"
                    method="post" autocomplete="off">
                    @csrf


                    <div class="modal-header">
                        <h5 class="modal-title">
                            إضافة وحدة —
                            <span class="text-muted font-16">{{ $ownerAssociation->name }}</span>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-row">

                            {{-- Property Type --}}
                            <div class="col-12">
                                <x-form-group :properties="[
                                    'select' => [
                                        'name' => 'property_type_id',
                                        'list' => getPropertyTypes(),
                                        'options' => [
                                            'class' => 'choices',
                                            'placeholder' => 'اختر نوع الوحدة',
                                        ],
                                    ],
                                    'label' => [
                                        'text' => 'نوع الوحدة',
                                        'options' => ['class' => 'required'],
                                    ],
                                ]" />
                            </div>

                            {{-- Unit Number --}}
                            <div class="col-md-6">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'unit_number',
                                        'type' => 'text',
                                        'options' => ['required'],
                                    ],
                                    'label' => [
                                        'text' => 'رقم الوحدة',
                                        'options' => ['class' => 'required'],
                                    ],
                                ]" />
                            </div>

                            {{-- Floor --}}
                            <div class="col-md-6">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'floor',
                                        'type' => 'text',
                                    ],
                                    'label' => [
                                        'text' => 'الدور',
                                    ],
                                ]" />
                            </div>

                            {{-- Owner (Client) --}}
                            <div class="col-12">
                                <x-dashboard.input-client-search label="مالك الوحدة" name="client_id" :required="false" />
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-main">إضافة الوحدة</button>
                        <button type="button" class="btn btn-outline-main" data-dismiss="modal">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Unit Owner Association -->
    <div class="modal fade" id="model-edit-unit-owner-association" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <form class="form" id="edit-unit-owner-association-form" method="post" autocomplete="off">
                    @csrf
                    @method('PATCH')

                    <div class="modal-header">
                        <h5 class="modal-title">
                            تعديل وحدة —
                            <span class="text-muted font-16">{{ $ownerAssociation->name }}</span>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-row">

                            {{-- Property Type --}}
                            <div class="col-12">
                                <x-form-group :properties="[
                                    'select' => [
                                        'name' => 'property_type_id',
                                        'list' => getPropertyTypes(),
                                        'options' => [
                                            'class' => 'choices edit-unit-select-property-type',
                                        ],
                                    ],
                                    'label' => [
                                        'text' => 'نوع الوحدة',
                                        'options' => ['class' => 'required'],
                                    ],
                                ]" />
                            </div>

                            {{-- Unit Number --}}
                            <div class="col-md-6">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'unit_number',
                                        'type' => 'text',
                                        'options' => ['required'],
                                    ],
                                    'label' => [
                                        'text' => 'رقم الوحدة',
                                        'options' => ['class' => 'required'],
                                    ],
                                ]" />
                            </div>

                            {{-- Floor --}}
                            <div class="col-md-6">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'floor',
                                        'type' => 'text',
                                    ],
                                    'label' => [
                                        'text' => 'الدور',
                                    ],
                                ]" />
                            </div>

                            {{-- Owner --}}
                            <div class="col-12">
                                <x-dashboard.input-client-search label="مالك الوحدة" name="client_id" :required="false" />
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-main">تحديث الوحدة</button>
                        <button type="button" class="btn btn-outline-main" data-dismiss="modal">
                            إلغاء
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- Modal edit Owner Association -->
    <div class="modal fade" id="model-edit-owner-association" tabindex="-1" role="dialog"
        aria-labelledby="modelTitleId" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">

                <form class="form" action="{{ route('owner-associations.update', $ownerAssociation) }}" method="post"
                    autocomplete="off">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">

                        <h5 class="modal-title">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                width="24px">
                                <path
                                    d="M240-320q-33 0-56.5-23.5T160-400q0-33 23.5-56.5T240-480q33 0 56.5 23.5T320-400q0 33-23.5 56.5T240-320Zm480 0q-33 0-56.5-23.5T640-400q0-33 23.5-56.5T720-480q33 0 56.5 23.5T800-400q0 33-23.5 56.5T720-320Zm-240-40q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM284-120q7-35 25-63.5t44-50.5q26-22 58.5-34t68.5-12q36 0 68.5 12t58.5 34q26 22 44 50.5t25 63.5H284Zm-153 0q-21 0-36-14t-15-32q0-39 47.5-76.5T237-280q17 0 33 3t31 9q-30 29-50 66.5T224-120h-93Zm605 0q-7-44-27-81.5T659-268q15-6 30.5-9t32.5-3q62 0 110 37.5t48 76.5q0 19-15 32.5T828-120h-92ZM64-512q-10-14-8-30t16-26l359-275q22-17 49-17t49 17l111 85v-22q0-25 17.5-42.5T700-840q25 0 42.5 17.5T760-780v114l128 98q13 10 15.5 26t-7.5 30q-10 14-26 16t-30-8L480-779 120-504q-14 10-30 8t-26-16Z" />
                            </svg>
                            تعديل الملف
                        </h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div><!-- modal-header -->

                    <div class="modal-body">

                        <div class="form-row">

                            {{-- Association Name --}}
                            <div class="col-12">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'name',
                                        'type' => 'text',
                                        'value' => $ownerAssociation->name,
                                        'options' => ['required'],
                                    ],
                                    'label' => [
                                        'text' => 'اسم ملف اتحاد الملاك',
                                        'options' => ['class' => 'required'],
                                    ],
                                ]" />
                            </div>

                            {{-- Manager Client --}}
                            <div class="col-12 ">
                                <x-dashboard.input-client-search
                                    valueText="{{ $ownerAssociation->manager ? $ownerAssociation->manager->name . ' — ' . $ownerAssociation->manager->phone : '' }}"
                                    valueId="{{ $ownerAssociation->id }}" label='المسؤول عن الاتحاد'
                                    name="manager_client_id" :required="false" />
                            </div>

                            {{-- Notes --}}
                            <div class="col-12">
                                <x-form-group :properties="[
                                    'textarea' => [
                                        'name' => 'notes',
                                        'value' => $ownerAssociation->notes,
                                        'options' => ['rows' => 3],
                                    ],
                                    'label' => [
                                        'text' => 'ملاحظات',
                                    ],
                                ]" />
                            </div>

                        </div><!-- form-row -->

                    </div><!-- modal-body -->

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-main">
                            تحديث الملف
                        </button>
                        <button type="button" class="btn btn-outline-main" data-dismiss="modal">
                            رجوع
                        </button>
                    </div><!-- modal-footer -->

                </form>

            </div>
        </div>
    </div>


    <!--------------------------------------------->

    <!-- Modal Add Owner Association -->
    <div class="modal fade" id="model-add-poll" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form class="form" action="{{ route('owner-associations.polls.store', $ownerAssociation) }}"
                    method="post" autocomplete="off">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">
                            <svg style="transform: scaleX(-1);" width="20" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 256 256">
                                <rect width="256" height="256" fill="none"></rect>
                                <path
                                    d="M40,200a8,8,0,0,0,13.15,6.12C105.55,162.16,160,160,160,160h40a40,40,0,0,0,0-80H160S105.55,77.84,53.15,33.89A8,8,0,0,0,40,40Z"
                                    fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="20"></path>
                                <path d="M156,79.67v121a8,8,0,0,0,3.56,6.65l15,7.33a8,8,0,0,0,12.2-4.72L200,160"
                                    fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="20"></path>
                            </svg>
                            إضافة استطلاع جديد
                        </h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-row">


                            {{-- Poll Title --}}
                            <div class="col-12">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'title',
                                        'type' => 'text',
                                        'options' => ['required'],
                                    ],
                                    'label' => [
                                        'text' => 'عنوان الاستطلاع',
                                        'options' => ['class' => 'required'],
                                    ],
                                ]" />
                            </div>

                            {{-- Description --}}
                            <div class="col-12">
                                <x-form-group :properties="[
                                    'textarea' => [
                                        'name' => 'description',
                                        'options' => [
                                            'rows' => 4,
                                            'placeholder' => 'شرح تفصيلي حول للاستطلاع (اختياري)',
                                        ],
                                    ],
                                    'label' => [
                                        'text' => 'الوصف',
                                    ],
                                ]" />
                            </div>

                            {{-- Is Active --}}
                            <div class="col-12 mt-2">
                                <div class="custom-control custom-switch custom-switch-rtl">
                                    <input type="checkbox" class="custom-control-input sr-only" id="is_active"
                                        name="is_active" value="1" checked>
                                    <label class="custom-control-label font-16" for="is_active">
                                        الاستطلاع مفتوح للتصويت
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-main">إضافة الاستطلاع</button>
                        <button type="button" class="btn btn-outline-main" data-dismiss="modal">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="model-edit-poll" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form class="form" action="{{ route('owner-associations.polls.store', $ownerAssociation) }}"
                    method="post" autocomplete="off">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <svg style="transform: scaleX(-1);" width="20" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 256 256">
                                <rect width="256" height="256" fill="none"></rect>
                                <path
                                    d="M40,200a8,8,0,0,0,13.15,6.12C105.55,162.16,160,160,160,160h40a40,40,0,0,0,0-80H160S105.55,77.84,53.15,33.89A8,8,0,0,0,40,40Z"
                                    fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="20"></path>
                                <path d="M156,79.67v121a8,8,0,0,0,3.56,6.65l15,7.33a8,8,0,0,0,12.2-4.72L200,160"
                                    fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="20"></path>
                            </svg>
                            تعديل الاستطلاع
                        </h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-row">


                            {{-- Poll Title --}}
                            <div class="col-12">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'title',
                                        'type' => 'text',
                                        'options' => ['required'],
                                    ],
                                    'label' => [
                                        'text' => 'عنوان الاستطلاع',
                                        'options' => ['class' => 'required'],
                                    ],
                                ]" />
                            </div>

                            {{-- Description --}}
                            <div class="col-12">
                                <x-form-group :properties="[
                                    'textarea' => [
                                        'name' => 'description',
                                        'options' => [
                                            'rows' => 4,
                                            'placeholder' => 'شرح تفصيلي حول للاستطلاع (اختياري)',
                                        ],
                                    ],
                                    'label' => [
                                        'text' => 'الوصف',
                                    ],
                                ]" />
                            </div>

                            {{-- Is Active --}}
                            <div class="col-12 mt-2">
                                <div class="custom-control custom-switch custom-switch-rtl">
                                    <input type="checkbox" class="custom-control-input sr-only" id="poll_edit_is_active"
                                        name="is_active" value="1" checked>
                                    <label class="custom-control-label font-16" for="poll_edit_is_active">
                                        الاستطلاع مفتوح للتصويت
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-main">تحديث</button>
                        <button type="button" class="btn btn-outline-main" data-dismiss="modal">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
<x-dashboard.js :links="[
    [
        'link' => 'owner-associations/index.js',
    ],
]" />
