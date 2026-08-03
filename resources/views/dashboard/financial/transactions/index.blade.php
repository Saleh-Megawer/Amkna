@extends('dashboard.layouts.master')

@section('title', 'المعاملات المالية')

@section('content')

    <section class="mb-5">

        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
            <div>
                <h2 class="mb-1">المعاملات المالية</h2>
                <p class="text-muted mb-0">إدارة وعرض جميع المعاملات المالية في النظام</p>
            </div>
            @can('financial_transactions_create')
                {{-- <a href="{{ route('financial.transactions.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M12 5l0 14"/>
                    <path d="M5 12l14 0"/>
                </svg>
                إضافة معاملة جديدة
            </a> --}}
            @endcan
        </div>

        {{-- Statistics Cards --}}
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="box text-center">
                    <div class="text-muted mb-2">إجمالي الإيرادات</div>
                    <h3 class="text-success mb-0">{{ number_format($stats['total_revenue']) }} ج.م</h3>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="box text-center">
                    <div class="text-muted mb-2">إجمالي المصروفات</div>
                    <h3 class="text-danger mb-0">{{ number_format($stats['total_expenses']) }} ج.م</h3>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="box text-center">
                    <div class="text-muted mb-2">صافي الربح</div>
                    <h3 class="text-primary mb-0">{{ number_format($stats['total_revenue'] - $stats['total_expenses']) }}
                        ج.م</h3>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="box text-center">
                    <div class="text-muted mb-2">المعاملات المعلقة</div>
                    <h3 class="text-warning mb-0">{{ $stats['pending'] }}</h3>
                </div>
            </div>
        </div>

        {{-- Search & Filter Form --}}
        @can('financial_transactions_search')
            <div class="box mb-3">
                <form method="GET" action="" autocomplete="off">
                    <div class="form-row mt-1">

                        <div class="col-lg-10 col-xl-11">
                            <div class="form-row">

                                <div class="col-xl-3 col-sm-6 col-6">
                                    <x-form-group class="mb-3 mb-lg-0" :properties="[
                                        'input' => [
                                            'name' => 'search',
                                            'type' => 'text',
                                            'value' => request('search'),
                                            'options' => [
                                                'class' => 'input-multi-search ltr text-right',
                                                'placeholder' => 'بحث بالوصف أو رقم الإيصال...',
                                            ],
                                        ],
                                        'label' => [
                                            'text' => 'البحث',
                                        ],
                                    ]" />
                                </div>

                                <div class="col-xl-2 col-sm-6 col-6">
                                    <div class="form-group mb-3 mb-lg-0">
                                        <label class="form-label">نوع المعاملة</label>
                                        <select name="type" class="form-control choices" data-search="false">
                                            <option value="">الكل</option>
                                            <option value="revenue" {{ request('type') == 'revenue' ? 'selected' : '' }}>إيرادات
                                            </option>
                                            <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>مصروفات
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-2 col-sm-6 col-6">
                                    <div class="form-group mb-3 mb-lg-0">
                                        <label class="form-label">الحالة</label>
                                        <select name="status" class="form-control choices" data-search="false">
                                            <option value="">الكل</option>
                                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>مدفوع
                                            </option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>معلق
                                            </option>
                                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                                ملغي</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-2 col-sm-6 col-6">
                                    <div class="form-group mb-3 mb-lg-0">
                                        <label class="form-label">الفئة</label>
                                        <select name="category" class="form-control choices">
                                            <option value="">الكل</option>
                                            <option value="rent_payment"
                                                {{ request('category') == 'rent_payment' ? 'selected' : '' }}>دفعة إيجار
                                            </option>
                                            <option value="maintenance"
                                                {{ request('category') == 'maintenance' ? 'selected' : '' }}>صيانة</option>
                                            <option value="electricity"
                                                {{ request('category') == 'electricity' ? 'selected' : '' }}>كهرباء</option>
                                            <option value="water" {{ request('category') == 'water' ? 'selected' : '' }}>مياه
                                            </option>
                                            <option value="gas" {{ request('category') == 'gas' ? 'selected' : '' }}>غاز
                                            </option>
                                            <option value="commission"
                                                {{ request('category') == 'commission' ? 'selected' : '' }}>عمولة</option>
                                            <option value="deposit_refund"
                                                {{ request('category') == 'deposit_refund' ? 'selected' : '' }}>رد تأمين
                                            </option>
                                            <option value="deposit_payment"
                                                {{ request('category') == 'deposit_payment' ? 'selected' : '' }}>دفع تأمين
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-sm-6 col-6">
                                    <div class="form-group mb-3 mb-lg-0">
                                        <label class="form-label">من تاريخ</label>
                                        <input type="date" name="from_date" class="form-control"
                                            value="{{ request('from_date') }}">
                                    </div>
                                </div>

                                <div class="col-xl-3 col-sm-6 col-6">
                                    <div class="form-group mb-3 mb-lg-0">
                                        <label class="form-label">إلى تاريخ</label>
                                        <input type="date" name="to_date" class="form-control"
                                            value="{{ request('to_date') }}">
                                    </div>
                                </div>

                                <div class="col-xl-3 col-sm-6 col-6">
                                    <div class="form-group mb-3 mb-lg-0">
                                        <label class="form-label">طريقة الدفع</label>
                                        <select name="payment_method" class="form-control choices" data-search="false">
                                            <option value="">الكل</option>
                                            <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>
                                                نقدي</option>
                                            <option value="bank_transfer"
                                                {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>تحويل بنكي
                                            </option>
                                            <option value="check"
                                                {{ request('payment_method') == 'check' ? 'selected' : '' }}>شيك</option>
                                            <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>
                                                بطاقة</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-sm-6 col-6">
                                    <div class="form-group mb-3 mb-lg-0">
                                        <label class="form-label">الترتيب</label>
                                        <select name="sort-order" class="form-control choices" data-search="false">
                                            <option value="desc"
                                                {{ request('sort-order', 'desc') == 'desc' ? 'selected' : '' }}>الأحدث أولاً
                                            </option>
                                            <option value="asc" {{ request('sort-order') == 'asc' ? 'selected' : '' }}>
                                                الأقدم أولاً</option>
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
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 10a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                    <path d="M21 21l-6 -6" />
                                </svg>
                                <span class="d-inline-block d-lg-none">بحث</span>
                            </button>
                        </div>

                    </div>
                </form>

                @if (request()->hasAny(['search', 'type', 'status', 'category', 'from_date', 'to_date', 'payment_method']) ||
                        request('sort-order') == 'asc')
                    <div class="mt-3">
                        <a href="" class="btn btn-sm btn-outline-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M18 6l-12 12" />
                                <path d="M6 6l12 12" />
                            </svg>
                            مسح جميع الفلاتر
                        </a>
                    </div>
                @endif
            </div>
        @endcan

        {{-- Statistics Summary --}}
        <div class="text-muted mb-3">
            إجمالي <strong class="text-dark">{{ $stats['total'] }}</strong>
            <span class="mx-1">|</span>
            مدفوعة <strong class="text-success">{{ $stats['paid'] }}</strong>
            <span class="mx-1">|</span>
            معلقة <strong class="text-warning">{{ $stats['pending'] }}</strong>
            <span class="mx-1">|</span>
            ملغاة <strong class="text-danger">{{ $stats['cancelled'] }}</strong>
        </div>

        {{-- Transactions Table --}}
        <div class="box table-responsive">
            <table class="table table-modern text-center table-modern-xs table-inverse">
                <thead class="thead-inverse">
                    <tr>
                        @canany(['financial_transactions_edit', 'financial_transactions_delete'])
                            <th class="noExl text-center">الإجراءات</th>
                        @endcanany
                        <th>#</th>
                        <th>النوع</th>
                        <th>الفئة</th>
                        <th>المبلغ</th>
                        <th>المصدر</th>
                        <th>الطرف المعني</th>
                        <th>طريقة الدفع</th>
                        <th>الحالة</th>
                        <th>تاريخ المعاملة</th>
                        <th class="noExl">الوصف</th>
                        <th class="noExl">المسجل بواسطة</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($transactions) > 0)
                        @foreach ($transactions as $row)
                            <tr data-id="{{ $row->uuid }}" class="parents">

                                @canany(['financial_transactions_edit', 'financial_transactions_delete'])
                                    <td class="noExl text-center">
                                        @can('financial_transactions_edit')
                                            <a href="" class="btn btn-xs btn-second" title="تعديل">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                    <path
                                                        d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                    <path d="M16 5l3 3" />
                                                </svg>
                                            </a>
                                        @endcan

                                        @can('financial_transactions_delete')
                                            <form class="d-inline-block ajax-delete" action="" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-xs btn-danger"
                                                    data-delete="هل أنت متأكد من حذف هذه المعاملة؟" title="حذف">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
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
                                        @endcan
                                    </td>
                                @endcanany

                                <td>{{ $row->id }}</td>

                                <td>
                                    @if ($row->type->value == 'revenue')
                                        <span class="badge badge-success badge-md">إيرادات</span>
                                    @else
                                        <span class="badge badge-danger badge-md">مصروفات</span>
                                    @endif
                                </td>

                                <td>
                                    @switch($row->category)
                                        @case('rent_payment')
                                            دفعة إيجار
                                        @break

                                        @case('maintenance')
                                            صيانة
                                        @break

                                        @case('electricity')
                                            كهرباء
                                        @break

                                        @case('water')
                                            مياه
                                        @break

                                        @case('gas')
                                            غاز
                                        @break

                                        @case('commission')
                                            عمولة
                                        @break

                                        @case('deposit_refund')
                                            رد تأمين
                                        @break

                                        @case('deposit_payment')
                                            دفع تأمين
                                        @break

                                        @case('internet')
                                            إنترنت
                                        @break

                                        @case('security')
                                            حراسة
                                        @break

                                        @case('cleaning')
                                            نظافة
                                        @break

                                        @default
                                            {{ $row->category }}
                                    @endswitch
                                </td>

                                <td class="ltr font-weight-bold">
                                    {!! currency_icon('xs') . ' ' . number_format($row->amount) !!}
                                </td>

                                {{-- Source (Polymorphic) --}}
                                <td>
                                    @if ($row->transactionable)
                                        @php
                                            $sourceType = class_basename(get_class($row->transactionable));
                                        @endphp

                                        @if ($sourceType == 'RentalContract')
                                            <a href="{{ route('rental.contracts.show', $row->transactionable->uuid) }}"
                                                class="text-primary" title="عقد إيجار">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                    <path
                                                        d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                                    <path d="M9 17h6" />
                                                    <path d="M9 13h6" />
                                                </svg>
                                                عقد {{ $row->transactionable->contract_number }}
                                            </a>
                                        @elseif($sourceType == 'Property')
                                            <a href="{{ route('properties.show', $row->transactionable->uuid) }}"
                                                class="text-info" title="عقار">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                                </svg>
                                                {{ $row->transactionable->title ?? 'عقار #' . $row->transactionable->id }}
                                            </a>
                                        @else
                                            <span class="badge badge-soft-secondary">{{ $sourceType }}</span>
                                        @endif
                                    @else
                                        <span class="text-muted">معاملة مستقلة</span>
                                    @endif
                                </td>

                                {{-- Related Party --}}
                                <td>
                                    @if ($row->type->value == 'revenue' && $row->receivedFrom)
                                        <a href="{{ route('crm.clients.show', $row->receivedFrom->uuid) }}"
                                            class="text-primary">
                                            {{ $row->receivedFrom->name }}
                                        </a>
                                    @elseif($row->type->value == 'expense' && $row->paidBy)
                                        <a href="{{ route('crm.clients.show', $row->paidBy->uuid) }}"
                                            class="text-primary">
                                            {{ $row->paidBy->name }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($row->payment_method)
                                        @switch($row->payment_method->value)
                                            @case('cash')
                                                نقدي
                                            @break

                                            @case('bank_transfer')
                                                تحويل بنكي
                                            @break

                                            @case('check')
                                                شيك
                                            @break

                                            @case('card')
                                                بطاقة
                                            @break

                                            @default
                                                <span class="badge badge-soft-secondary">{{ $row->payment_method }}</span>
                                        @endswitch
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>


                                <td>
                                    <span
                                        class="{{ $row->status->badge() }} badge-md">{{ $row->status->label() }}</span>
                                </td>

                                <td class="ltr">{{ $row->transaction_date->format('Y-m-d') }}</td>

                                <td class="noExl">
                                    @if ($row->description)
                                        <span class="text-truncate d-inline-block" style="max-width: 200px;"
                                            title="{{ $row->description }}">
                                            {{ $row->description }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                <td class="noExl">{{ $row->admin?->full_name ?? '-' }}</td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="13" class="text-center pt-4 text-muted">
                                @if (request()->hasAny(['search', 'type', 'status', 'category']))
                                    لا توجد نتائج للبحث
                                    <a href="{{ route('financial.transactions.index') }}" class="text-danger">
                                        مسح جميع الفلاتر
                                    </a>
                                @else
                                    لا توجد معاملات مالية بعد
                                @endif
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <x-paginate :data="$transactions" />

    </section>


@endsection
