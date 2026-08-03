@extends('dashboard.layouts.master')
@section('title', 'تفاصيل العقد #' . $contract->contract_number)
@section('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/pages/rental/show.css') }}">
@endsection
@section('content')

    <x-dashboard.links-bar :links="[
        [
            'name' => 'عقود الإيجار',
            'link' => route('rental.contracts.index'),
        ],
        [
            'name' => 'تفاصيل العقد #' . $contract->contract_number,
        ],
    ]" /><!-- links bar -->

    {{-- Header Section --}}
    <div class="modern-card mb-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

            <div style="flex: 1; min-width: 250px;">

                <div class="d-flex align-items-center mb-2">
                    <h3 class="mb-0 ml-3 fs-clamp-16-26">
                        عقد إيجار {{ $contract->contract_number }}
                    </h3>

                    <span class="badge-sm {{ $contract->status->badge() }}">
                        {{ $contract->status->label() }}
                    </span>
                </div>


                <p class=" font-15 text-muted mb-0 ltr">
                    <svg style="margin-top: -4px" xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-week">
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
                    من {{ $contract->start_date_formatted }} إلى {{ $contract->end_date_formatted }}
                </p>

            </div>

            <div class=" d-flex  mt-2 mt-sm-0">
                <div style="width: 110px" class="dropdown d-inline-block dropdown-basic mb-0">

                    <button class="btn btn-secondary btn-block dropdown-toggle" type="button" id="dropdownContractActions"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-settings">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065" />
                            <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                        </svg>
                        التحكم
                    </button>

                    <div class="dropdown-menu" aria-labelledby="dropdownContractActions">

                        <a class="dropdown-item" href="{{ route('rental.contracts.edit', $contract->uuid) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                <path d="M16 5l3 3" />
                            </svg>
                            تعديل العقد
                        </a>

                        <form class="dropdown-item ajax-delete"
                            action="{{ route('rental.contracts.destroy', $contract->uuid) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button style="color: #ff0000" type="submit"
                                data-delete="هل انت متأكد من حذف العقد رقم: {{ $contract->contract_number }}"
                                class="p-0 bg-transparent">
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
                        </form>

                    </div>
                </div>

                {{-- في الـ show.blade.php أو index --}}
                <div class="input-normal-style mr-2">
                    <div class="form-group mb-0 ">
                        <select style="height: 39px" class="form-control change-contract-status"
                            data-contract-id="{{ $contract->uuid }}" data-current-status="{{ $contract->status }}">
                            @foreach ($availableStatuses as $avaStatus)
                                <option @selected($contract->status->value == $avaStatus['id']) value="{{ $avaStatus['id'] }}">
                                    {{ $avaStatus['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row mb-2">
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-content">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05.82 1.87 2.65 1.87 1.96 0 2.4-.98 2.4-1.59 0-.83-.44-1.61-2.67-2.14-2.48-.6-4.18-1.62-4.18-3.67 0-1.72 1.39-2.84 3.11-3.21V4h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.64-1.87-2.22-1.87-1.5 0-2.4.68-2.4 1.64 0 .84.65 1.39 2.67 1.91s4.18 1.39 4.18 3.91c-.01 1.83-1.38 2.83-3.12 3.16z" />
                        </svg>
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">إجمالي الإيجار</span>
                        <h4 class="stat-value ltr">{!! currency_icon() . ' ' . number_format($contract->total_rent_amount) !!}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="stat-card stat-success">
                <div class="stat-content">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                        </svg>
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">المدفوع</span>
                        <h4 class="stat-value ltr" style="color: #10b981;">{!! currency_icon('md', '#10b981') . ' ' . number_format($stats['collected'] ?? 0) !!}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="stat-card stat-warning">
                <div class="stat-content">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M11 7h2v2h-2zm0 4h2v6h-2zm1-9C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z" />
                        </svg>
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">المتبقي</span>
                        <h4 class="stat-value ltr" style="color: #f59e0b;">{!! currency_icon('md', '#f59e0b') . ' ' . number_format($stats['remaining'] ?? 0) !!}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="stat-card stat-danger">
                <div class="stat-content">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                        </svg>
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">المتأخر</span>
                        <h4 class="stat-value ltr" style="color: #ef4444;">{!! currency_icon('md', '#ef4444') . ' ' . number_format($stats['overdue'] ?? 0) !!}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-lg-8">

            {{-- معلومات العقد - تصميم مضغوط --}}
            <div class="modern-card mb-4">
                <div class="section-header">
                    <svg class="section-icon" viewBox="0 0 24 24">
                        <path
                            d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z" />
                    </svg>
                    <h5>معلومات العقد</h5>
                </div>

                <div class="info-section">
                    <div class="row">
                        <div class="col-md-4 col-6 mb-2">
                            <div class="info-item">
                                <span class="info-label">رقم العقد</span>
                                <p class="info-value mb-0">{{ $contract->contract_number }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 col-6 mb-2">
                            <div class="info-item">
                                <span class="info-label">تاريخ البداية</span>
                                <p class="info-value mb-0">{{ $contract->start_date_formatted }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 col-6 mb-2">
                            <div class="info-item">
                                <span class="info-label">تاريخ النهاية</span>
                                <p class="info-value mb-0">{{ $contract->end_date_formatted }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="info-item">
                                <span class="info-label">دورية الدفع</span>
                                <p class="info-value mb-0">
                                    {{ $contract->payment_frequency->label() }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="info-item">
                                <span class="info-label">قيمة الدفعة</span>
                                <p class="info-value mb-0">{{ number_format($contract->expected_payment_amount) }} ج.م</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- معلومات الأطراف - تصميم مضغوط --}}
            <div class="row">

                <div class="col-lg-6">
                    <div class="modern-card mb-4">
                        <div class="section-header">
                            <h5>معلومات المالك</h5>
                        </div>

                        <div class="form-row">

                            <div class="col-6 mb-3">
                                <div class="info-section">
                                    <div class="info-item">
                                        <span class="info-label">المالك</span>
                                        <p class="info-value mb-1">{{ $contract->owner->name ?? '-' }}</p>
                                    </div><!--  -->
                                </div>
                            </div><!-- name -->

                            <div class="col-6 mb-3">
                                <div class="info-section">
                                    <div class="info-item">
                                        <span class="info-label">رقم الجوال</span>
                                        <p class="info-value mb-1 ltr">
                                            {{ $contract->owner->country_code }}{{ $contract->owner->phone }}</p>
                                    </div><!--  -->
                                </div>
                            </div><!-- phone -->

                            <div class="col-6 mb-3">
                                <div class="info-section">
                                    <div class="info-item">
                                        <span class="info-label">تاريخ الميلاد</span>
                                        <p class="info-value mb-1">{{ $contract->owner?->birth_date ?? '-' }}</p>
                                    </div>
                                </div>
                            </div><!-- birth_date -->

                            <div class="col-6 mb-3">
                                <div class="info-section">
                                    <div class="info-item">
                                        <span class="info-label">الهوية</span>
                                        <p class="info-value mb-1">{{ $contract->owner->national_id ?? '-' }}</p>
                                    </div>
                                </div>
                            </div><!-- national_id -->

                            <div class="col-md-12">
                                <div class="info-section">
                                    <div class="info-item">
                                        <span class="info-label">العنوان الوطني</span>
                                        <p class="info-value mb-1">{{ $contract->owner->national_address ?? '-' }}</p>
                                    </div>
                                </div>
                            </div><!-- national_address -->

                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="modern-card mb-4">
                        <div class="section-header">
                            <h5>معلومات المستأجر</h5>
                        </div>

                        <div class="form-row">

                            <div class="col-6 mb-3">
                                <div class="info-section">
                                    <div class="info-item">
                                        <span class="info-label">المستأجر</span>
                                        <p class="info-value mb-1">{{ $contract->tenant->name ?? '-' }}</p>
                                    </div><!--  -->
                                </div>
                            </div><!-- name -->

                            <div class="col-6 mb-3">
                                <div class="info-section">
                                    <div class="info-item">
                                        <span class="info-label">رقم الجوال</span>
                                        <p class="info-value mb-1 ltr">
                                            {{ $contract->tenant->country_code }}{{ $contract->tenant->phone }}</p>
                                    </div><!--  -->
                                </div>
                            </div><!-- phone -->

                            <div class="col-6 mb-3">
                                <div class="info-section">
                                    <div class="info-item">
                                        <span class="info-label">تاريخ الميلاد</span>
                                        <p class="info-value mb-1">{{ $contract->tenant?->birth_date ?? '-' }}</p>
                                    </div>
                                </div>
                            </div><!-- birth_date -->

                            <div class="col-6 mb-3">
                                <div class="info-section">
                                    <div class="info-item">
                                        <span class="info-label">الهوية</span>
                                        <p class="info-value mb-1">{{ $contract->tenant->national_id ?? '-' }}</p>
                                    </div>
                                </div>
                            </div><!-- national_id -->

                            <div class="col-md-12">
                                <div class="info-section">
                                    <div class="info-item">
                                        <span class="info-label">العنوان الوطني</span>
                                        <p class="info-value mb-1">{{ $contract->tenant->national_address ?? '-' }}</p>
                                    </div>
                                </div>
                            </div><!-- national_address -->

                        </div>
                    </div>
                </div>

            </div><!-- end row -->


            {{-- معلومات العقار - تصميم مضغوط --}}
            <div class="modern-card mb-4">

                <div class="section-header">
                    <svg class="section-icon" viewBox="0 0 24 24">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                    </svg>
                    <h5>معلومات العقار</h5>
                </div>

                @if ($contract->property)
                    <div class="info-section">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="info-item">
                                    <span class="info-label">عنوان العقار</span>
                                    <p class="info-value mb-0">{{ $contract->property->title_normalized_ar }}</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="info-item">
                                    <span class="info-label">نوع العقار</span>
                                    <p class="info-value mb-0">{{ $contract->property->propertyType->name ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="info-item">
                                    <span class="info-label">المساحة</span>
                                    <p class="info-value mb-0">{{ $contract->property->area }} م²</p>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <div class="info-item">
                                    <span class="info-label">الصك</span>
                                    <p class="info-value mb-0">{{ $contract->deed_number }}</p>
                                </div>
                            </div><!--  -->

                        </div>
                    </div>
                @elseif($contract->propertyDetails)
                    <div class="info-section">
                        <div class="row">
                            <div class="col-12">
                                <div class="info-item">
                                    <span class="info-label">العنوان</span>
                                    <p class="info-value mb-0">{{ $contract->propertyDetails->address ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="info-item">
                                    <span class="info-label">نوع العقار</span>
                                    <p class="info-value mb-0">{{ $contract->propertyDetails->propertyType->name ?? '-' }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="info-item">
                                    <span class="info-label">المساحة</span>
                                    <p class="info-value mb-0">{{ $contract->propertyDetails->area }} م²</p>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <div class="info-item">
                                    <span class="info-label">الصك</span>
                                    <p class="info-value mb-0">{{ $contract->deed_number }}</p>
                                </div>
                            </div><!--  -->

                        </div>
                    </div>
                @else
                    <p style="color: var(--color-second); margin: 0;">لا توجد معلومات عقار</p>
                @endif
            </div>

            {{-- جدول الدفعات --}}
            <div class="modern-card mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <svg style="width: 24px; height: 24px; fill: var(--second-color); margin-left: 0.75rem;"
                            viewBox="0 0 24 24">
                            <path
                                d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                        </svg>
                        <h5 class="mb-0 font-weight-700">جدول الدفعات</h5>
                    </div>
                </div>

                <div style="max-height: 500px" class="table-responsive">
                    <table class="table table-modern table-modern-sm table-modern-bordered text-center mb-0">
                        <thead>
                            <tr>
                                <th>الإجراءات</th>
                                <th>#</th>
                                <th>تاريخ الاستحقاق</th>
                                <th>المبلغ</th>
                                <th>الحالة</th>
                                <th>تاريخ الدفع</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($contract->paymentSchedules as $payment)
                                <tr>
                                    <td>
                                        @if ($payment->status->value != 'paid')
                                            {{-- <form class="ajax-swal-info"
                                                action="{{ route('rental.contracts.change-status', $contract) }}"
                                                method="POST">
                                                @method('PATCH')
                                                @csrf
                                                <button class="btn btn-sm btn-success" type="submit"
                                                    data-info="هل تم إستلام دفعة {{ $payment->due_date_formatted }} ?">
                                                    تسجيل دفع
                                                </button>
                                            </form> --}}
                                            <button type="button" class="btn btn-sm btn-outline-main"
                                                onclick="openPaymentModal({{ $payment->id }})">
                                                تسجيل الدفعة
                                            </button>
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td><strong>{{ $loop->iteration }}</strong></td>
                                    <td>{{ $payment->due_date_formatted }}</td>
                                    <td class="ltr">
                                        <span class="font-weight-500">{!! currency_icon('xs') . ' ' . number_format($payment->amount) !!}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-md {{ $payment->resolved_status->badge() }}">
                                            {{ $payment->resolved_status->label() }}
                                        </span>
                                    </td>
                                    <td class="ltr">{{ $payment->paid_at ?? '-' }}</td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4" style="color: var(--color-second);">
                                        لا توجد دفعات
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- المصروفات --}}
            {{-- <div class="modern-card mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center">
                    <svg style="width: 24px; height: 24px; fill: var(--second-color); margin-left: 0.75rem;"
                        viewBox="0 0 24 24">
                        <path
                            d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
                    </svg>
                    <h5 class="mb-0 font-weight-700">المصروفات</h5>
                </div>
                <a href="{{ route('rental.expenses.create', $contract->id) }}" class="btn btn-sm btn-main">
                    <svg style="width: 14px; height: 14px; margin-left: 0.375rem;" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                    </svg>
                    إضافة مصروف
                </a>
            </div>

            <div class="table-responsive">
                <table class="table modern-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>التاريخ</th>
                            <th>الفئة</th>
                            <th>المبلغ</th>
                            <th>الوصف</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contract->expenses ?? [] as $expense)
                        <tr>
                            <td><strong>{{ $loop->iteration }}</strong></td>
                            <td>{{ $expense->transaction_date }}</td>
                            <td>{{ $expense->category }}</td>
                            <td><strong style="color: #ef4444;">{{ number_format($expense->amount) }} ج.م</strong>
                            </td>
                            <td>{{ $expense->description }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4" style="color: var(--color-second);">
                                لا توجد مصروفات
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
               </div> --}}


        </div>

        <div class="col-lg-4">

            {{-- المعلومات المالية --}}
            <div class="modern-card mb-3">
                <div class="section-header">
                    <svg class="section-icon" viewBox="0 0 24 24">
                        <path
                            d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
                    </svg>
                    <h5>المعلومات المالية</h5>
                </div>

                <div class="info-section">
                    <div class="info-item">
                        <span class="info-label">مبلغ التأمين</span>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="info-value mb-0 ltr">{!! currency_icon('xs') . ' ' . number_format($contract->deposit_amount) !!}</p>
                            <span class="badge-md {{ $contract->deposit_status->badge() }}">
                                {{ $contract->deposit_status->label() }}
                            </span>
                        </div>
                    </div>

                    <div class="info-item">
                        <span class="info-label">مبلغ العمولة</span>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="info-value mb-0 ltr">{!! currency_icon('xs') . ' ' . number_format($contract->commission_amount) !!}</p>
                            <span class="badge-md {{ $contract->commission_status->badge() }}">
                                {{ $contract->commission_status->label() }}
                            </span>

                        </div>
                    </div>
                    {{--
                <div class="info-item">
                    <span class="info-label">إجمالي المصروفات</span>
                    <p class="info-value mb-0" style="color: #ef4444;">
                        {{ number_format($stats['total_expenses'] ?? 0) }} ج.م</p>
                </div> --}}
                </div>
            </div>

            {{-- الملاحظات --}}
            @if ($contract->notes)
                <div class="modern-card mb-3">
                    <div class="section-header">
                        <svg class="section-icon" viewBox="0 0 24 24">
                            <path
                                d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-7 9h-2V5h2v6zm0 4h-2v-2h2v2z" />
                        </svg>
                        <h5>الملاحظات</h5>
                    </div>
                    <p style="color: var(--card-color); line-height: 1.5; margin: 0; font-size: 0.9375rem;">
                        {{ $contract->notes }}</p>
                </div>
            @endif

            {{-- معلومات إضافية --}}
            <div class="modern-card mb-4">
                <div class="section-header">
                    <svg class="section-icon" viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                    </svg>
                    <h5>معلومات إضافية</h5>
                </div>

                <div class="info-section">
                    <div class="info-item">
                        <span class="info-label">الموظف المسؤول</span>
                        <p class="info-value mb-0">{{ $contract->admin->full_name ?? '-' }}</p>
                    </div>

                    <div class="info-item">
                        <span class="info-label">تاريخ الإنشاء</span>
                        <p class="info-value mb-0">{{ $contract->created_at->format('Y-m-d h:i A') }}</p>
                    </div>

                    <div class="info-item">
                        <span class="info-label">آخر تحديث</span>
                        <p class="info-value mb-0">{{ $contract->updated_at->format('Y-m-d h:i A') }}</p>
                    </div>
                </div>
            </div>


            <div class="modern-card">

                <div class="section-header">
                    <svg class="section-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" color="#d0a968" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-logs">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M4 12h.01" />
                        <path d="M4 6h.01" />
                        <path d="M4 18h.01" />
                        <path d="M8 18h2" />
                        <path d="M8 12h2" />
                        <path d="M8 6h2" />
                        <path d="M14 6h6" />
                        <path d="M14 12h6" />
                        <path d="M14 18h6" />
                    </svg>
                    <h5>معلومات إضافية</h5>
                </div>

                <div style="max-height: 300px;overflow-y:auto;" class="activity-timeline pl-2">

                    @forelse($logs as $log)

                        @php
                            $props = $log->properties?->toArray() ?? [];
                            $attributes = $props['attributes'] ?? [];
                            $old = $props['old'] ?? [];
                        @endphp

                        <div class="activity-item d-flex">

                            <div class="activity-line ml-2">
                                <span class="dot"></span>
                            </div>

                            <div class="activity-content flex-grow-1">

                                <div class="mb-1">
                                    <strong>
                                        @if ($log->event === 'created')
                                            تم إنشاء العقد
                                        @elseif($log->event === 'updated')
                                            تحديث بيانات
                                        @elseif($log->event === 'deleted')
                                            تم حذف العقد
                                        @else
                                            {{ $log->description }}
                                        @endif
                                    </strong>
                                </div>

                                <div class="d-flex justify-co ntent-between align-items-center mb-2">
                                    <div class="text-muted small tip" title="القائم بالإجراء">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                            <path d="M9 10a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                            <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                                        </svg>
                                        {{ optional($log->causer)->full_name ?? 'النظام' }}
                                    </div>

                                    <span class="mx-1">•</span>
                                    <div class="text-muted small ltr">
                                        {{ $log->created_at->format('Y-m-d • H:ia') }}
                                    </div>
                                </div>

                                @if ($log->event === 'updated' && count($attributes))
                                    <div class="activity-details text-muted">

                                        @foreach ($attributes as $field => $newValue)
                                            @if (isset($old[$field]) && $old[$field] != $newValue)
                                                @php
                                                    $oldValue = match ($field) {
                                                        'status' => \App\Enums\Rental\RentalContractStatus::fromLog(
                                                            $old[$field],
                                                        ),
                                                        'deposit_status' => \App\Enums\Rental\DepositStatus::fromLog(
                                                            $old[$field],
                                                        ),
                                                        'commission_status'
                                                            => \App\Enums\Rental\CommissionStatus::fromLog(
                                                            $old[$field],
                                                        ),
                                                        'payment_frequency'
                                                            => \App\Enums\Rental\PaymentFrequency::fromLog(
                                                            $old[$field],
                                                        ),
                                                        default => $old[$field],
                                                    };

                                                    $newFormatted = match ($field) {
                                                        'status' => \App\Enums\Rental\RentalContractStatus::fromLog(
                                                            $newValue,
                                                        ),
                                                        'deposit_status' => \App\Enums\Rental\DepositStatus::fromLog(
                                                            $newValue,
                                                        ),
                                                        'commission_status'
                                                            => \App\Enums\Rental\CommissionStatus::fromLog($newValue),
                                                        'payment_frequency'
                                                            => \App\Enums\Rental\PaymentFrequency::fromLog($newValue),
                                                        default => $newValue,
                                                    };
                                                @endphp

                                                <div>
                                                    تم تغيير
                                                    <strong>{{ \App\Models\Dashboard\Rental\RentalContract::logFieldLabel($field) }}</strong>
                                                    من "<span>{{ $oldValue }}</span>"
                                                    إلى "<span>{{ $newFormatted }}</span>"
                                                </div>
                                            @endif
                                        @endforeach

                                    </div>
                                    @if (!$loop->last)
                                        <hr>
                                    @endif
                                @endif

                            </div>
                        </div>

                    @empty
                        <p class="text-muted text-center py-3">لا يوجد نشاط بعد</p>
                    @endforelse

                </div>

            </div>


        </div>


    </div>


@endsection
@section('js')

    <script>
        // في ملف rental-contracts.js أو في blade
        $(document).on('change', '.change-contract-status', function() {
            const $select = $(this);
            const contractId = $select.data('contract-id');
            const currentStatus = $select.data('current-status');
            const newStatus = $select.val();

            // لو اختار نفس الحالة، متعملش حاجة
            if (currentStatus === newStatus) {
                return;
            }

            // Send Ajax Request
            $.ajax({
                url: adminUrl + `/rental/contracts/change-status/${contractId}`,
                type: 'PATCH',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    status: newStatus
                },
                success: function(response) {

                    iziToast.success({
                        message: response.message,
                    });


                    // Update current status
                    $select.data('current-status', newStatus);

                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.message || 'حدث خطأ أثناء تحديث الحالة';
                    iziToast.error({
                        message: message,
                    });
                }
            });
        });

        function openPaymentModal(scheduleId) {
            // جلب الـ Modal من الـ Backend
            $.get("{{ route('rental.payments.modal', ':id') }}".replace(':id', scheduleId))
                .done(function(response) {

                    // حذف أي modal قديم
                    $('#payment-modal').remove();

                    // إضافة الـ Modal الجديد
                    $('body').append(response.html);

                    // تفعيل Choices.js
                    if (typeof initChoices === 'function') {
                        initChoices();
                    }

                    // فتح الـ Modal
                    $('#payment-modal').modal('show');

                    // // Handle Form Submit
                    // $('#payment-form').on('submit', function(e) {
                    //     e.preventDefault();

                    //     const scheduleId = $(this).data('schedule-id');
                    //     const formData = $(this).serialize();

                    //     $.ajax({
                    //         url: "{{ route('rental.payments.store', ':id') }}".replace(':id',
                    //             scheduleId),
                    //         method: 'POST',
                    //         data: formData,
                    //         success: function(response) {
                    //             $('#payment-modal').modal('hide');

                    //             // Show success message
                    //             alert('تم تسجيل الدفعة بنجاح');

                    //             // Reload page
                    //             location.reload();
                    //         },
                    //         error: function(xhr) {
                    //             alert('حدث خطأ أثناء تسجيل الدفعة');
                    //         }
                    //     });
                    // });

                })
                .fail(function() {
                    alert('حدث خطأ في تحميل نموذج الدفع');
                });
        }
    </script>


@endsection
