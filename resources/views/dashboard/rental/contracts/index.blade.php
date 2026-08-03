@extends('dashboard.layouts.master')
@section('title', 'عقود الإيجار')
@section('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/pages/rental/show.css') }}">
@endsection
@section('content')


    <x-dashboard.links-bar :links="[
        [
            'name' => 'عقود الإيجار',
        ],
    ]" :buttons="[
        [
            'name' => '+ إضافة عقد',
            'class' => 'btn-main',
            'link' => route('rental.contracts.create'),
        ],
    ]" /><!-- links bar -->

    {{-- Filters --}}
    <div class="box mb-3">
        <form method="GET" action="{{ route('rental.contracts.index') }}" autocomplete="off">
            <div class="form-row mt-1">

                <div class="col-lg-10 col-xl-11">
                    <div class="form-row">

                        {{-- البحث --}}
                        <div class="col-xl-4 col-sm-6 col-6">
                            <div class="form-group mb-3 mb-lg-0">
                                <label class="form-label">البحث</label>
                                <input type="text" name="search" class="form-control input-multi-search ltr text-right"
                                    placeholder="برقم العقد أو اسم المستأجر..." value="{{ request('search') }}">
                            </div>
                        </div>

                        {{-- الحالة --}}
                        <div class="col-xl-2 col-sm-6 col-6">
                            <div class="form-group mb-3 mb-lg-0">
                                <label class="form-label">الحالة</label>
                                <select name="status" class="form-control choices" data-search="false">
                                    <option value="">كل الحالات</option>
                                    @foreach ($rentalContractStatusOptions as $statusOption)
                                        <option value="{{ $statusOption['id'] }}"
                                            {{ request('status') == $statusOption['id'] ? 'selected' : '' }}>
                                            {{ $statusOption['name'] }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        {{-- نوع العقار --}}
                        <div class="col-xl-2 col-sm-6 col-6">
                            <div class="form-group mb-3 mb-lg-0">
                                <label class="form-label">نوع العقار</label>
                                <select name="property_type" class="form-control choices">
                                    <option value="">كل الأنواع</option>
                                    @foreach (getPropertyTypes() as $type)
                                        <option value="{{ $type->id }}"
                                            {{ request('property_type') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- من تاريخ --}}
                        <div class="col-xl-2 col-sm-6 col-6">
                            <div class="form-group mb-3 mb-lg-0">
                                <label class="form-label">من تاريخ</label>
                                <input type="date" name="from_date" class="form-control ltr text-right"
                                    value="{{ request('from_date') }}">
                            </div>
                        </div>

                        {{-- إلى تاريخ --}}
                        <div class="col-xl-2 col-sm-6 col-6">
                            <div class="form-group mb-3 mb-lg-0">
                                <label class="form-label">إلى تاريخ</label>
                                <input type="date" name="to_date" class="form-control ltr text-right"
                                    value="{{ request('to_date') }}">
                            </div>
                        </div>

                    </div>
                </div>

                {{-- زر البحث --}}
                <div class="col-lg-2 col-xl-1 d-flex">
                    <button type="submit" class="btn btn-second btn-block align-self-lg-stretch align-self-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 10a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                            <path d="M21 21l-6 -6" />
                        </svg>
                        <span class="d-inline-block d-lg-none">بحث</span>
                    </button>
                </div>

            </div>
        </form>

        {{-- مسح الفلاتر --}}
        @if (request()->hasAny(['search', 'status', 'property_type', 'from_date', 'to_date']) || request('sort_order') == 'asc')
            <div class="mt-3">
                <a href="{{ route('rental.contracts.index') }}" class="btn btn-sm btn-outline-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M18 6l-12 12" />
                        <path d="M6 6l12 12" />
                    </svg>
                    مسح جميع الفلاتر
                </a>
            </div>
        @endif
    </div>

    {{-- Statistics Cards --}}
    <div class="row mb-2">
        {{-- إجمالي العقود --}}
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-content">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z" />
                        </svg>
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">إجمالي العقود</span>
                        <h4 class="stat-value">{{ $stats['total'] ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- عقود نشطة --}}
        <div class="col-md-3 mb-3">
            <div class="stat-card stat-success">
                <div class="stat-content">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                        </svg>
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">عقود نشطة</span>
                        <h4 class="stat-value" style="color: #10b981;">{{ $stats['active'] ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- عقود منتهية --}}
        <div class="col-md-3 mb-3">
            <div class="stat-card stat-warning">
                <div class="stat-content">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                        </svg>
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">عقود منتهية</span>
                        <h4 class="stat-value" style="color: #f59e0b;">{{ $stats['expired'] ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- إجمالي الإيرادات --}}
        <div class="col-md-3 mb-3">
            <div class="stat-card stat-primary">
                <div class="stat-content">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05.82 1.87 2.65 1.87 1.96 0 2.4-.98 2.4-1.59 0-.83-.44-1.61-2.67-2.14-2.48-.6-4.18-1.62-4.18-3.67 0-1.72 1.39-2.84 3.11-3.21V4h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.64-1.87-2.22-1.87-1.5 0-2.4.68-2.4 1.64 0 .84.65 1.39 2.67 1.91s4.18 1.39 4.18 3.91c-.01 1.83-1.38 2.83-3.12 3.16z" />
                        </svg>
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">إجمالي الإيرادات</span>
                        <h4 class="stat-value ltr" style="color: #3b82f6;">{!! currency_icon('md', '#3b82f6') . ' ' . number_format($stats['total_revenue'] ?? 0) !!}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- Contracts Table --}}
    <div class="box box-table">
        <div class="table-responsive">
            <table class="table table-modern text-center table-modern-sm mb-0">
                <thead>
                    <tr>
                        <th>الإجراءات</th>
                        <th>#</th>
                        <th>رقم العقد</th>
                        <th>العقار</th>
                        <th>التاريخ من - إلى</th>
                        <th>قيمة الإيجار</th>
                        <th>الحالة</th>
                        <th>المستأجر</th>
                        <th>المالك</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contracts as $contract)
                        <tr class="parents">
                            <td class=" d-flex justify-content-center">

                                <a href="{{ route('rental.contracts.show', $contract->uuid) }}"
                                    class="btn btn-sm btn-info tip" title="عرض">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path
                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg>
                                </a>

                                <a href="{{ route('rental.contracts.edit', $contract->uuid) }}"
                                    class="btn btn-sm btn-soft-primary mx-1 tip" title="تعديل">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415" />
                                        <path d="M16 5l3 3" />
                                    </svg>
                                </a>

                                <form class="ajax-delete" action="{{ route('rental.contracts.destroy', $contract) }}"
                                    method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit"
                                        data-delete="هل انت متأكد من حذف العقد رقم: {{ $contract->contract_number }}"
                                        class="btn btn-sm btn-soft-danger tip">
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
                                    </button>
                                </form>


                            </td>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ route('rental.contracts.show', $contract->uuid) }}"
                                    class="text-primary font-weight-bold">
                                    {{ $contract->contract_number }}
                                </a>
                            </td>
                            <td>
                                @if ($contract->property)
                                    {{ $contract->property->title }}
                                @elseif($contract->propertyDetails)
                                    {{ $contract->propertyDetails->address ?? 'عقار خارجي' }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                {{ $contract->start_date_formatted }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5 12l14 0" />
                                    <path d="M5 12l6 6" />
                                    <path d="M5 12l6 -6" />
                                </svg>
                                {{ $contract->end_date_formatted }}
                            </td>

                            <td class="ltr">{!! currency_icon('xs') . ' ' . number_format($contract->total_rent_amount) !!}</td>
                            <td>
                                <span
                                    class=" badge badge-md {{ $contract->status->badge() }}">{{ $contract->status->label() }}</span>
                            </td>

                            <td>{{ $contract->tenant->name ?? '-' }}</td>
                            <td>{{ $contract->owner->name ?? '-' }}</td>


                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-muted">
                                لا توجد عقود
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($contracts->hasPages())
            <div class="mt-3">
                {{ $contracts->withQueryString()->links() }}
            </div>
        @endif
    </div>

    {{-- Delete Form --}}
    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

@endsection
@section('js')

    <script></script>

@endsection
