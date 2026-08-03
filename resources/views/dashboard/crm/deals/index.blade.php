@php
    $exportSvg =
        '<span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-table-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12.5 21h-7.5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v7.5" /><path d="M3 10h18" /><path d="M10 3v18" /><path d="M19 16v6" /><path d="M22 19l-3 3l-3 -3" /></svg></span>';
@endphp
@extends('dashboard.layouts.master')
@section('title', $linksMap->index->page_title)
<x-dashboard.css :links="[
    [
        'link' => 'deals/index.css',
    ],
]" />
@section('content')

    <x-dashboard.links-bar :links="[
        [
            'name' => $linksMap->index->page_title,
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
        [
            'name' => '<i class=\'fa fa-plus\'></i> إضافة صفقة',
            'class' => 'btn-main',
            'can' => 'deals_create',
            'options' => [
                'data-toggle' => 'modal',
                'data-target' => '#model-add-deal',
            ],
        ],
    ]" /><!-- links bar -->


    {{-- Search Form --}}
    @can('deals_allow_search')
        <div class="box mb-3 pt-3">
            <h5 class="font-20 font-weight-600 mb-3">البحث</h5>
            <form method="GET" action="{{ route('crm.deals.index') }}" autocomplete="off">
                <div class="form-row mt-1">
                    <div class="col-lg-10 col-xl-11">
                        <div class="form-row">

                            {{-- البحث --}}
                            <div class="col-xl-4 col-12">
                                <div class="form-group mb-3 mb-lg-0">
                                    <label class="form-label">البحث عن عميل</label>
                                    <input type="text" name="search" class="form-control"
                                        placeholder="بالاسم أو رقم الهاتف..." value="{{ request('search') }}">
                                </div>
                            </div>

                            {{-- نوع الصفقة --}}
                            <div class="col-xl-2 col-sm-6 col-6">
                                <div class="form-group mb-3 mb-lg-0">
                                    <label class="form-label">نوع الصفقة</label>
                                    <select name="purpose" class="form-control choices" data-search="false">
                                        <option value="">الكل</option>
                                        <option value="buy" @selected(request('purpose') == 'buy')>شراء</option>
                                        <option value="rent" @selected(request('purpose') == 'rent')>إيجار</option>
                                    </select>
                                </div>
                            </div>

                            {{-- نوع العقار --}}
                            <div class="col-xl-2 col-sm-6 col-6">
                                <div class="form-group mb-3 mb-lg-0">
                                    <label class="form-label">نوع العقار</label>
                                    <select name="property_type" class="form-control choices">
                                        <option value="">الكل</option>
                                        @foreach ($propertyTypes as $type)
                                            <option value="{{ $type->id }}" @selected(request('property_type') == $type->id)>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- المكلف --}}
                            <div class="col-xl-2 col-sm-6 col-6">
                                <div class="form-group mb-3 mb-lg-0">
                                    <label class="form-label">المكلف</label>
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

                            {{-- الترتيب --}}
                            <div class="col-xl-2 col-sm-6 col-6">
                                <div class="form-group mb-3 mb-lg-0">
                                    <label class="form-label">الترتيب</label>
                                    <select name="sort-order" class="form-control choices" data-search="false">
                                        <option value="desc" @selected(request('sort-order', 'desc') == 'desc')>الأحدث</option>
                                        <option value="asc" @selected(request('sort-order') == 'asc')>الأقدم</option>
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

            @if (request()->hasAny(['search', 'purpose', 'property_type', 'status', 'assigned-to']) ||
                    request('sort-order') == 'asc')
                <div class="mt-3">
                    <a href="{{ route('crm.deals.index') }}" class="btn btn-sm btn-outline-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6l-12 12" />
                            <path d="M6 6l12 12" />
                        </svg>
                        مسح جميع الفلاتر
                    </a>
                </div>
            @endif
        </div>
    @endcan

    {{-- Statistics --}}
    <div class="text-muted mb-3">
        <strong class="text-dark">{{ $stats['total'] }}</strong> إجمالي
        <span class="mx-1">|</span>
        <strong class="text-success">{{ $stats['won'] }}</strong> صفقة ناجحة
        <span class="mx-1">|</span>
        <strong class="text-danger">{{ $stats['lost'] }}</strong> خاسرة
        <span class="mx-1">|</span>
        <strong class="text-info">{{ $stats['in_progress'] }}</strong> قيد المتابعة
    </div>


    <section id="" class="mb-5">

        <div class="box form-box pt-3 table-responsive">
            <h5 class=" fs-clamp-16-20 mb-3 font-weight-600">جدول {{ $linksMap->index->page_title }}</h5>

            <table  class="table table-modern table-modern-xs table-striped text-center borde r-right border-top table-inverse">

                <thead class="thead-inverse">
                    <tr>
                        @canany(['deals_view_details'])
                            <th>الإجراءات</th>
                        @endcanany

                        <th title="الرقم التعريفي للصفقة" class="tip">رقم</th>
                        <th>العميل</th>
                        <th>الهاتف</th>
                        <th>نوع الصفقة</th>
                        <th>نوع العقار</th>
                        <th>حالة الصفقة</th>
                        @if (!isSalesAdmin())
                            <th class="noExl">المكلّف</th>
                        @endif
                        <th>قيمة الصفقة</th>
                        <th>الملاحظات</th>
                        <th>تاريخ الإنشاء</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($deals as $row)
                        <tr class="parents">


                            @if (isSalesAdmin())
                                @if ($row->assigned_to === adminId())
                                    <td>
                                        <a href="{{ route('crm.deals.edit', $row) }}" class="btn btn-xs btn-second tip"
                                            title="عرض الصفقة">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                <path
                                                    d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                            </svg>
                                        </a>
                                    </td><!-- actions -->
                                @endif
                            @else
                                @if (canPermission('deals_view_details'))
                                    <td>
                                        <a href="{{ route('crm.deals.edit', $row) }}" class="btn btn-xs btn-second tip"
                                            title="عرض الصفقة">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                <path
                                                    d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                            </svg>
                                        </a>
                                    </td><!-- actions -->
                                @endif
                            @endif




                            <td>#{{ $row->id }}</td>


                            {{-- Client Name --}}
                            <td>{{ optional($row->client)->name ?? '-' }}</td>

                            {{-- Phone --}}
                            <td class="ltr">
                                {{ optional($row->client)->country_code ? '(' . optional($row->client)->country_code . ') ' : '' }}
                                {{ optional($row->client)->phone ?? '-' }}
                            </td>


                            {{-- Deal Purpose --}}
                            <td>
                                {{ $row->purpose->label() }}
                            </td>

                            {{-- Property Type --}}
                            <td>{{ optional($row->propertyType)->name ?? '-' }}</td>



                            {{-- Property Type --}}
                            <td>
                                @switch(true)
                                    @case($row->is_won)
                                        <span style="width: 80px"
                                            class="badge font-weight-500 badge-success badge-md">ناجحة</span>
                                    @break

                                    @case($row->is_lost)
                                        <span style="width: 80px" class="badge font-weight-500 badge-danger badge-md">
                                            خاسرة
                                        </span>
                                    @break

                                    @default
                                        <span style="width: 80px" class="badge font-weight-500 badge-info badge-md">قيد
                                            المتابعة</span>
                                @endswitch
                            </td>



                            {{-- Assigned Admin --}}

                            @if (isSalesAdmin())
                                {{-- Sales: لا يظهر شيء --}}
                            @elseif (canPermission('deals_change_assigned_admin'))
                                <td class="noExl" style="max-width: 250px;">
                                    <x-dashboard.assign-admin :row="$row" :action="route('crm.deals.assign', $row->uuid)" />
                                </td>
                            @else
                                <td class="noExl">
                                    {{ $row->assignedTo->full_name }}
                                </td>
                            @endif


                            {{-- Amount --}}
                            <td class="ltr">
                                @if ($row->amount)
                                    {!! currency_icon('xs') !!} {{ number_format($row->amount) }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            {{-- Notes --}}
                            <td>
                                @if ($row->notes)
                                    <x-dashboard.text-preview :text="$row->notes" limit="25" />
                                @endif
                            </td>

                            {{-- Created At --}}
                            <td class="ltr">{{ $row->created_at->format('Y-m-d • H:i A') }}</td>


                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        {{-- بعد الجدول --}}
        <x-paginate :data="$deals" />

    </section><!-- section -->


@endsection
