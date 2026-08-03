@php
    $exportSvg =
        '<span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-table-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12.5 21h-7.5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v7.5" /><path d="M3 10h18" /><path d="M10 3v18" /><path d="M19 16v6" /><path d="M22 19l-3 3l-3 -3" /></svg></span>';
@endphp
@extends('dashboard.layouts.master')
@section('title', $linksMap->all_follow_ups->page_title . ' - ' . $linksMap->index->page_title)
<x-dashboard.css :links="[
    [
        'link' => 'deals/follow-ups.css',
    ],
]" />
@section('content')


    <x-dashboard.links-bar :links="[
        [
            'name' => $linksMap->index->page_title,
            'link' => $linksMap->index->route,
        ],
        [
            'name' => $linksMap->all_follow_ups->page_title,
        ],
    ]" :buttons="[
        [
            'name' => $exportSvg . ' تصدير البيانات',
            'class' => 'btn-light bg-white',
            'can' => 'deals_export_data',
            'options' => [
                'id' => 'exportExcel',
            ],
        ],
    ]" /><!-- links bar -->




    <section class="mb-5">

        {{-- Statistics Cards --}}
        <div class="row mb-2">

            {{-- إجمالي المتابعات --}}
            <div class="col-sm-6 col-lg-3 mb-3">
                <a href="{{ route('crm.deals.follow-ups.index') }}" class="text-decoration-none">
                    <div class="stat-card stat-card-primary">
                        <div class="stat-card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div class="stat-card-content">
                            <h3 class="stat-card-value">{{ $stats['total'] }}</h3>
                            <p class="stat-card-label">إجمالي المتابعات</p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- متابعات اليوم --}}
            <div class="col-sm-6 col-lg-3 mb-3">
                <a href="{{ route('crm.deals.follow-ups.index', ['date_from' => today()->format('Y-m-d'), 'date_to' => today()->format('Y-m-d')]) }}"
                    class="text-decoration-none">
                    <div class="stat-card stat-card-info">
                        <div class="stat-card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z">
                                </path>
                                <path d="M16 3v4"></path>
                                <path d="M8 3v4"></path>
                                <path d="M4 11h16"></path>
                                <path d="M8 15h2v2h-2z"></path>
                            </svg>
                        </div>
                        <div class="stat-card-content">
                            <h3 class="stat-card-value">{{ $stats['today'] }}</h3>
                            <p class="stat-card-label">متابعات اليوم</p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- قيد الانتظار --}}
            <div class="col-sm-6 col-lg-3 mb-3">
                <a href="{{ route('crm.deals.follow-ups.index', ['status' => 'pending']) }}" class="text-decoration-none">
                    <div class="stat-card stat-card-warning">
                        <div class="stat-card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                <path d="M12 7v5l3 3"></path>
                            </svg>
                        </div>
                        <div class="stat-card-content">
                            <h3 class="stat-card-value">{{ $stats['pending'] }}</h3>
                            <p class="stat-card-label">قيد الانتظار</p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- المكتملة --}}
            <div class="col-sm-6 col-lg-3 mb-3">
                <a href="{{ route('crm.deals.follow-ups.index', ['status' => 'completed']) }}" class="text-decoration-none">
                    <div class="stat-card stat-card-success">
                        <div class="stat-card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                <path d="M9 12l2 2l4 -4"></path>
                            </svg>
                        </div>
                        <div class="stat-card-content">
                            <h3 class="stat-card-value">{{ $stats['completed'] }}</h3>
                            <p class="stat-card-label">المكتملة</p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- المتأخرة (Overdue) - اختياري --}}
            @if (isset($stats['overdue']) && $stats['overdue'] > 0)
                <div class="col-sm-6 col-lg-3 mb-3">
                    <a href="{{ route('crm.deals.follow-ups.index', ['overdue' => '1']) }}" class="text-decoration-none">
                        <div class="stat-card stat-card-danger">
                            <div class="stat-card-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M12 9v4"></path>
                                    <path
                                        d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z">
                                    </path>
                                    <path d="M12 16h.01"></path>
                                </svg>
                            </div>
                            <div class="stat-card-content">
                                <h3 class="stat-card-value">{{ $stats['overdue'] }}</h3>
                                <p class="stat-card-label">متأخرة</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endif

        </div>

        {{-- Search Form --}}
        <div class="box mb-4 pt-4">
            <h5 class="font-20 font-weight-600 mb-4">البحث</h5>

            <form method="GET" action="{{ route('crm.deals.follow-ups.index') }}" autocomplete="off">
                <div class="form-row mt-1">

                    <div class="col-lg-10 col-xl-11">
                        <div class="form-row">

                            {{-- من تاريخ --}}
                            <div class="col-xl-2 col-sm-6 col-6">
                                <div class="form-group mb-3 mb-lg-0">
                                    <label class="form-label">من تاريخ</label>
                                    <input type="date" name="date_from" class="form-control"
                                        value="{{ request('date_from') }}">
                                </div>
                            </div>

                            {{-- إلى تاريخ --}}
                            <div class="col-xl-2 col-sm-6 col-6">
                                <div class="form-group mb-3 mb-lg-0">
                                    <label class="form-label">إلى تاريخ</label>
                                    <input type="date" name="date_to" class="form-control"
                                        value="{{ request('date_to') }}">
                                </div>
                            </div>

                            {{-- المسؤول --}}

                            <div class="col-xl-4 col-sm-12 col-12">
                                <div class="form-group mb-3 mb-lg-0">
                                    <label class="form-label">المسؤول</label>
                                    <select name="assigned-to" class="form-control choices">
                                        <option value="">الكل</option>
                                        @foreach ($admins as $admin)
                                            <option value="{{ $admin->id }}" @selected(request('assigned-to') == $admin->id)>
                                                {{ $admin->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- الحالة --}}
                            <div class="col-xl-2 col-sm-6 col-6">
                                <div class="form-group mb-3 mb-lg-0">
                                    <label class="form-label">الحالة</label>
                                    <select name="status" class="form-control choices" data-search="false">
                                        <option value="">الكل</option>
                                        @foreach (\App\Enums\Deal\DealFollowUpStatus::cases() as $status)
                                            <option value="{{ $status->value }}" @selected(request('status') == $status->value)>
                                                {{ $status->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- الأولوية --}}
                            <div class="col-xl-2 col-sm-6 col-6">
                                <div class="form-group mb-3 mb-lg-0">
                                    <label class="form-label">الأولوية</label>
                                    <select name="priority" class="form-control choices" data-search="false">
                                        <option value="">الكل</option>
                                        @foreach (\App\Enums\Deal\DealFollowUpPriority::cases() as $priority)
                                            <option value="{{ $priority->value }}" @selected(request('priority') == $priority->value)>
                                                {{ $priority->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-2 col-xl-1 d-flex">
                        <button type="submit" class="btn btn-second btn-block align-self-lg-stretch align-self-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M3 10a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                <path d="M21 21l-6 -6" />
                            </svg>
                            <span class="d-inline-block d-lg-none">بحث</span>
                        </button>
                    </div>

                </div>
            </form>
            @if (request()->hasAny(['date_from', 'date_to', 'assigned-to', 'status', 'priority', 'client']))
                <div class="mt-3">
                    <a href="{{ route('crm.deals.follow-ups.index') }}" class="btn btn-sm btn-outline-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M18 6l-12 12" />
                            <path d="M6 6l12 12" />
                        </svg>
                        مسح جميع الفلاتر
                    </a>
                </div>
            @endif
        </div>

        <div class="box table-responsive">
            <h5 class=" fs-clamp-16-20 font-weight-600">جدول {{ $linksMap->all_follow_ups->page_title }}</h5>
            <table class="table table-modern text-center table-modern-bordered mt-3 table-modern-xs table-inverse">
                <thead class="thead-inverse">
                    <tr>
                        <th class="noExl text-center">الإجراءات</th>
                        <th>#</th>
                        <th>نوع المتابعة</th>
                        <th>التفاصيل & الملاحظات</th>
                        <th>الموعد</th>
                        <th>الأولوية</th>
                        <th>الحالة</th>
                        <th>الصفقة</th>
                        <th>العميل</th>
                        <th class="noExl">المسؤول</th>
                        <th class="noExl">أضيف بواسطة</th>
                        <th>تاريخ الإنشاء</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($followUps as $row)
                        <tr class="{{ $row->is_overdue ? 'bg-danger-light' : '' }}">

                            <td>
                                <div class="d-flex justify-content-center">

                                    @can('deals_edit_followup')
                                        <button type="button" class="btn btn-sm btn-outline-primary btn-edit-follow-up ml-1"
                                            data-follow-up-id="{{ $row->id }}"
                                            data-deal-uuid="{{ $row->deal?->uuid }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                <path
                                                    d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z">
                                                </path>
                                                <path d="M16 5l3 3"></path>
                                            </svg>
                                        </button>

                                        @if ($row->status->value == 'pending')
                                            <form
                                                action="{{ route('crm.deals.follow-ups.mark-completed', [$row->deal, $row->id]) }}"
                                                method="POST">
                                                @method('PATCH')
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success ml-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M5 12l5 5l10 -10" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    @endcan


                                    @can('deals_delete_followup')
                                        <x-dashboard.delete-form :action="route('crm.deals.follow-ups.delete', [$row->deal, $row->id])"
                                            button-class="btn btn-sm btn-outline-danger " icon-only />
                                    @endcan

                                </div>
                            </td>

                            <td>{{ $row->id }}</td>

                            <td>
                                <span class="ml-1">{!! $row->follow_up_type->icon() !!}</span>
                                {{ $row->follow_up_type->label() }}
                            </td>

                            <td>
                                @if ($row->notes)
                                    <x-dashboard.text-preview :text="$row->notes" limit="30" />
                                @else
                                    -
                                @endif
                            </td>

                            <td class="ltr ">

                                @if ($row->is_pending && $row->is_scheduled_today)
                                    <img style="object-fit: contain;margin-top:-2px;" width="20px" height="15px"
                                        src="{{ asset('dashboard/images/icons8-sand-clock-100.gif') }}" alt="">
                                @endif
                                <span class="{{ $row->is_overdue ? 'text-danger' : '' }}">
                                    {{ $row->scheduled_at->format('Y-m-d') }}
                                    <small class="ltr">{{ $row->scheduled_at->format('h:i A') }}</small>
                                </span>

                            </td>
                            <td>
                                <span class="badge badge-md {{ $row->priority->badgeClass() }}">
                                    {{ $row->priority->label() }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-md {{ $row->status->badgeClass() }}">
                                    {{ $row->status->label() }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('crm.deals.edit', $row->deal->uuid) }}" target="_blank">
                                    #{{ $row->deal->id ?? '-' }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('crm.clients.show', $row->deal?->client?->uuid) }}" target="_blank"
                                    rel="noopener noreferrer">
                                    {{ $row->deal?->client?->name ?? '-' }}
                                </a>
                            </td>
                            <td class="noExl">{{ $row->assignedAdmin->full_name ?? '-' }}</td>
                            <td class="noExl">{{ $row->creator->full_name ?? '-' }}</td>
                            <td class="ltr">{{ $row->created_at->format('Y-m-d • H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center pt-4 text-muted">
                                لا توجد متابعات
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        {{-- Pagination --}}
        <x-paginate :data="$followUps" />

    </section>




@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/jquery-table2excel@1.1.1/dist/jquery.table2excel.min.js"></script>
    <script>
        $('#exportExcel').on('click', function() {
            $('.table').table2excel({
                name: 'Follow Ups Data',
                exclude: '.noExl',
                filename: 'followups_' + Date.now() + '.xls',
                preserveColors: false
            });
        });
    </script>
@endpush
<x-dashboard.js :links="[
    [
        'link' => 'deals/follow-up.js',
    ],
]" />
